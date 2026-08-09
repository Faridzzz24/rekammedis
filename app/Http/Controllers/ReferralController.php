<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $query = Referral::with([
            'medicalRecord.patient',
            'fromDoctor.user',
            'fromHospital',
            'toDoctor.user',
            'toHospital',
        ]);

        $user = auth()->user();

        if ($user->role === 'doctor' && $user->doctor) {
            $query->where(function ($q) use ($user) {
                $q->where('from_doctor_id', $user->doctor->id)
                  ->orWhere('to_doctor_id', $user->doctor->id);
            });
        }

        if ($user->role === 'patient' && $user->patient) {
            $query->whereHas('medicalRecord', function ($q) use ($user) {
                $q->where('patient_id', $user->patient->id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $referrals = $query->latest()->paginate(10);
        return view('referrals.index', compact('referrals'));
    }

    public function create(Request $request)
    {
        $medicalRecord = null;
        if ($request->has('medical_record_id')) {
            $medicalRecord = MedicalRecord::with(['patient', 'doctor.user', 'hospital'])->find($request->medical_record_id);
        }

        $doctors = Doctor::with(['user', 'hospital'])->get();
        $hospitals = Hospital::all();
        $medicalRecords = MedicalRecord::with('patient')
            ->whereDoesntHave('referral')
            ->latest('visit_date')
            ->get();

        return view('referrals.create', compact('doctors', 'hospitals', 'medicalRecords', 'medicalRecord'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'to_doctor_id' => 'required|exists:doctors,id',
            'to_hospital_id' => 'required|exists:hospitals,id',
            'reason' => 'required|string',
            'notes' => 'nullable|string',
            'priority' => 'required|in:normal,urgent,emergency',
        ]);

        $medicalRecord = MedicalRecord::findOrFail($validated['medical_record_id']);

        Referral::create([
            'medical_record_id' => $validated['medical_record_id'],
            'from_doctor_id' => $medicalRecord->doctor_id,
            'from_hospital_id' => $medicalRecord->hospital_id,
            'to_doctor_id' => $validated['to_doctor_id'],
            'to_hospital_id' => $validated['to_hospital_id'],
            'reason' => $validated['reason'],
            'notes' => $validated['notes'],
            'priority' => $validated['priority'],
            'status' => 'pending',
        ]);

        return redirect()->route('referrals.index')
            ->with('success', 'Rujukan berhasil dibuat. Data medis pasien telah dikirim ke dokter tujuan.');
    }

    public function show(Referral $referral)
    {
        $referral->load([
            'medicalRecord.patient',
            'medicalRecord.doctor.user',
            'medicalRecord.hospital',
            'fromDoctor.user',
            'fromHospital',
            'toDoctor.user',
            'toHospital',
        ]);

        // Load semua rekam medis pasien untuk riwayat lengkap
        $patientHistory = MedicalRecord::with(['doctor.user', 'hospital'])
            ->where('patient_id', $referral->medicalRecord->patient_id)
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('referrals.show', compact('referral', 'patientHistory'));
    }

    public function accept(Referral $referral)
    {
        $referral->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return redirect()->route('referrals.show', $referral)
            ->with('success', 'Rujukan berhasil diterima.');
    }

    public function complete(Referral $referral)
    {
        $referral->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('referrals.show', $referral)
            ->with('success', 'Rujukan telah selesai.');
    }

    public function reject(Referral $referral, Request $request)
    {
        $request->validate(['notes' => 'required|string']);

        $referral->update([
            'status' => 'rejected',
            'notes' => $referral->notes . "\n\nAlasan penolakan: " . $request->notes,
        ]);

        return redirect()->route('referrals.show', $referral)
            ->with('success', 'Rujukan telah ditolak.');
    }
}
