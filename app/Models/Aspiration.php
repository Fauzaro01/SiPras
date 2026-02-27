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
        'bukti_foto',
        'status',
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
     * Get all feedbacks for the aspiration
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class)->with('user')->latest();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'diajukan' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai'  => 'bg-green-100 text-green-800',
            'ditolak'  => 'bg-red-100 text-red-800',
            default    => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label in Bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }
}
