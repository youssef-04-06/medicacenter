<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'message',
        'reply',
        'replied_by',
        'replied_at',
    ];

    protected $casts = ['replied_at' => 'datetime'];

    public function patient() { return $this->belongsTo(User::class, 'user_id'); }
}