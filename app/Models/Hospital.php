<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'type',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function referralsFrom()
    {
        return $this->hasMany(Referral::class, 'from_hospital_id');
    }

    public function referralsTo()
    {
        return $this->hasMany(Referral::class, 'to_hospital_id');
    }
}
