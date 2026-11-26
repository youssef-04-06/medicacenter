<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'recipient_type',
        'subject',
        'message',
        'reply',
        'replied_by',
        'replied_at',
    ];

    protected $casts = ['replied_at' => 'datetime'];

    public function patient() { return $this->belongsTo(User::class, 'user_id'); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function replier() { return $this->belongsTo(User::class, 'replied_by'); }
}
