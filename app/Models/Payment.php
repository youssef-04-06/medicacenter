<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'user_id',
        'doctor_id',
        'amount',
        'payment_method',
        'status',
        'sender_number',
        'reference',
    ];

    protected $casts = ['amount' => 'decimal:2'];

    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function patient() { return $this->belongsTo(User::class, 'user_id'); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
}
