<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Referral;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        } elseif ($user->role === 'doctor') {
            return $this->doctorDashboard();
        } else {
            return $this->patientDashboard();
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'hospitals' => Hospital::count(),
            'doctors' => Doctor::count(),
            'patients' => Patient::count(),
            'referrals' => Referral::where('status', 'pending')->count(),
            'records' => MedicalRecord::count(),
        ];

        $recentRecords = MedicalRecord::with(['patient', 'doctor.user', 'hospital'])
            ->latest('visit_date')
            ->limit(5)
            ->get();

        $recentReferrals = Referral::with(['fromDoctor.user', 'toDoctor.user', 'fromHospital', 'toHospital'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentRecords', 'recentReferrals'));
    }

    private function doctorDashboard()
    {
        $doctor = auth()->user()->doctor;

        if (!$doctor) {
            return view('dashboard', ['stats' => [], 'recentRecords' => collect(), 'recentReferrals' => collect()]);
        }

        $stats = [
            'patients_today' => MedicalRecord::where('doctor_id', $doctor->id)
                ->whereDate('visit_date', today())
                ->count(),
            'total_patients' => MedicalRecord::where('doctor_id', $doctor->id)
                ->distinct('patient_id')
                ->count('patient_id'),
            'pending_referrals' => Referral::where('to_doctor_id', $doctor->id)
                ->where('status', 'pending')
                ->count(),
            'records' => MedicalRecord::where('doctor_id', $doctor->id)->count(),
        ];

        $recentRecords = MedicalRecord::with(['patient', 'hospital'])
            ->where('doctor_id', $doctor->id)
            ->latest('visit_date')
            ->limit(5)
            ->get();

        $recentReferrals = Referral::with(['fromDoctor.user', 'toDoctor.user', 'fromHospital', 'toHospital', 'medicalRecord.patient'])
            ->where(function ($query) use ($doctor) {
                $query->where('to_doctor_id', $doctor->id)
                    ->orWhere('from_doctor_id', $doctor->id);
            })
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentRecords', 'recentReferrals'));
    }

    private function patientDashboard()
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            return view('dashboard', ['stats' => [], 'recentRecords' => collect(), 'recentReferrals' => collect()]);
        }

        $stats = [
            'total_visits' => MedicalRecord::where('patient_id', $patient->id)->count(),
            'hospitals_visited' => MedicalRecord::where('patient_id', $patient->id)
                ->distinct('hospital_id')
                ->count('hospital_id'),
            'active_referrals' => Referral::whereHas('medicalRecord', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })->whereIn('status', ['pending', 'accepted'])->count(),
        ];

        $recentRecords = MedicalRecord::with(['doctor.user', 'hospital'])
            ->where('patient_id', $patient->id)
            ->latest('visit_date')
            ->limit(5)
            ->get();

        $recentReferrals = Referral::with(['fromDoctor.user', 'toDoctor.user', 'fromHospital', 'toHospital'])
            ->whereHas('medicalRecord', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentRecords', 'recentReferrals'));
    }
}
