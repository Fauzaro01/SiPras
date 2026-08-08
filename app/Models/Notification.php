<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'data', 'read_at'];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Human‑readable message based on type
    public function getMessageAttribute()
    {
        return match($this->type) {
            'new_aspiration' => "Aspirasi baru: " . ($this->data['title'] ?? ''),
            'status_change' => "Status aspirasi " . ($this->data['title'] ?? '') . " berubah menjadi " . ($this->data['new_status'] ?? ''),
            default => 'Notifikasi',
        };
    }
}
