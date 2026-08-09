<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::withCount('doctors')->latest()->paginate(10);
        return view('hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        return view('hospitals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'type' => 'required|in:umum,khusus,klinik',
        ]);

        Hospital::create($validated);

        return redirect()->route('hospitals.index')
            ->with('success', 'Rumah sakit berhasil ditambahkan.');
    }

    public function show(Hospital $hospital)
    {
        $hospital->load(['doctors.user']);
        return view('hospitals.show', compact('hospital'));
    }

    public function edit(Hospital $hospital)
    {
        return view('hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, Hospital $hospital)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'type' => 'required|in:umum,khusus,klinik',
        ]);

        $hospital->update($validated);

        return redirect()->route('hospitals.index')
            ->with('success', 'Data rumah sakit berhasil diperbarui.');
    }

    public function destroy(Hospital $hospital)
    {
        $hospital->delete();

        return redirect()->route('hospitals.index')
            ->with('success', 'Rumah sakit berhasil dihapus.');
    }
}
