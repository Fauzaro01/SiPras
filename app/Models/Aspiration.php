<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspiration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'judul',
        'deskripsi',
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
     * Get the category of the aspiration
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
