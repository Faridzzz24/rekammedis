<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['user', 'hospital'])->latest()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $hospitals = Hospital::all();
        return view('doctors.create', compact('hospitals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'hospital_id' => 'required|exists:hospitals,id',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|unique:doctors,license_number',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'hospital_id' => $validated['hospital_id'],
            'specialization' => $validated['specialization'],
            'license_number' => $validated['license_number'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('doctors.index')
            ->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'hospital', 'medicalRecords.patient']);
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $hospitals = Hospital::all();
        $doctor->load('user');
        return view('doctors.edit', compact('doctor', 'hospitals'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'hospital_id' => 'required|exists:hospitals,id',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctor->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $doctor->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($request->filled('password')) {
            $doctor->user->update(['password' => Hash::make($request->password)]);
        }

        $doctor->update([
            'hospital_id' => $validated['hospital_id'],
            'specialization' => $validated['specialization'],
            'license_number' => $validated['license_number'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('doctors.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();
        return redirect()->route('doctors.index')
            ->with('success', 'Dokter berhasil dihapus.');
    }
}
