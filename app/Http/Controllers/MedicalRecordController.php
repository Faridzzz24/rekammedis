<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor.user', 'hospital']);
        $user = auth()->user();

        // Dokter hanya lihat rekam medisnya sendiri
        if ($user->role === 'doctor' && $user->doctor) {
            $query->where('doctor_id', $user->doctor->id);
        }

        // Pasien hanya lihat rekam medisnya sendiri
        if ($user->role === 'patient' && $user->patient) {
            $query->where('patient_id', $user->patient->id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $records = $query->latest('visit_date')->paginate(10);
        return view('medical-records.index', compact('records'));
    }

    public function create(Request $request)
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::with('user')->get();
        $hospitals = Hospital::all();

        $selectedPatient = null;
        if ($request->has('patient_id')) {
            $selectedPatient = Patient::find($request->patient_id);
        }

        return view('medical-records.create', compact('patients', 'doctors', 'hospitals', 'selectedPatient'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'complaint' => 'required|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'blood_pressure_sys' => 'nullable|numeric',
            'blood_pressure_dia' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'heart_rate' => 'nullable|integer',
            'visit_date' => 'required|date',
        ]);

        $record = MedicalRecord::create($validated);

        return redirect()->route('medical-records.show', $record)
            ->with('success', 'Rekam medis berhasil disimpan.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor.user', 'hospital', 'referral.toDoctor.user', 'referral.toHospital']);
        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::with('user')->get();
        $hospitals = Hospital::all();

        return view('medical-records.edit', compact('medicalRecord', 'patients', 'doctors', 'hospitals'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'complaint' => 'required|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'blood_pressure_sys' => 'nullable|numeric',
            'blood_pressure_dia' => 'nullable|numeric',
            'temperature' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'heart_rate' => 'nullable|integer',
            'visit_date' => 'required|date',
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('medical-records.show', $medicalRecord)
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
            ->with('success', 'Rekam medis berhasil dihapus.');
    }
}
