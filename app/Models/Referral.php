<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'from_doctor_id',
        'from_hospital_id',
        'to_doctor_id',
        'to_hospital_id',
        'reason',
        'notes',
        'status',
        'priority',
        'accepted_at',
        'completed_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function fromDoctor()
    {
        return $this->belongsTo(Doctor::class, 'from_doctor_id');
    }

    public function fromHospital()
    {
        return $this->belongsTo(Hospital::class, 'from_hospital_id');
    }

    public function toDoctor()
    {
        return $this->belongsTo(Doctor::class, 'to_doctor_id');
    }

    public function toHospital()
    {
        return $this->belongsTo(Hospital::class, 'to_hospital_id');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'accepted' => 'info',
            'completed' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    public function getPriorityBadgeAttribute()
    {
        return match($this->priority) {
            'normal' => 'info',
            'urgent' => 'warning',
            'emergency' => 'danger',
            default => 'secondary',
        };
    }
}
