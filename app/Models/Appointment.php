<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'doctor_id',     // link to doctors table
        'schedule_id',   // link to doctor_schedules table
        'appointment_type',
        'appointment_details',
        'message',
        'zoom_meeting_link',
        'zoom_join_url',
        'zoom_start_url',
        'zoom_meeting_id',
        'status',
    ];

    protected $casts = [
        'appointment_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relationship to DoctorSchedule
    public function schedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id');
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}