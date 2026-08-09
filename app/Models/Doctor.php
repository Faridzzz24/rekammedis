<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hospital_id',
        'specialization',
        'license_number',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function referralsFrom()
    {
        return $this->hasMany(Referral::class, 'from_doctor_id');
    }

    public function referralsTo()
    {
        return $this->hasMany(Referral::class, 'to_doctor_id');
    }

    public function getFullNameAttribute()
    {
        return $this->user->name;
    }
}
