<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:patients,nik',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date',
            'birth_place' => 'nullable|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies' => 'nullable|string',
            'create_account' => 'nullable|boolean',
            'email' => 'nullable|required_if:create_account,1|email|unique:users,email',
            'password' => 'nullable|required_if:create_account,1|string|min:8',
        ]);

        $userId = null;
        if ($request->create_account) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'patient',
            ]);
            $userId = $user->id;
        }

        Patient::create([
            'user_id' => $userId,
            'nik' => $validated['nik'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
            'birth_place' => $validated['birth_place'] ?? null,
            'address' => $validated['address'],
            'phone' => $validated['phone'] ?? null,
            'blood_type' => $validated['blood_type'] ?? null,
            'allergies' => $validated['allergies'] ?? null,
        ]);

        return redirect()->route('patients.index')
            ->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['medicalRecords.doctor.user', 'medicalRecords.hospital', 'medicalRecords.referral']);
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:patients,nik,' . $patient->id,
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date',
            'birth_place' => 'nullable|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        if ($patient->user_id) {
            $patient->user->delete();
        }
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Pasien berhasil dihapus.');
    }
}
