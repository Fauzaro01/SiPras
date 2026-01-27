<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspiration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'kategori',
        'lokasi',
        'status',
        'tanggapan_admin',
    ];

    /**
     * Get the user that owns the aspiration
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
