<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'hospital_id',
        'complaint',
        'diagnosis',
        'treatment',
        'prescription',
        'notes',
        'blood_pressure_sys',
        'blood_pressure_dia',
        'temperature',
        'weight',
        'heart_rate',
        'visit_date',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function referral()
    {
        return $this->hasOne(Referral::class);
    }
}
