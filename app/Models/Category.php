<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    /**
     * Get aspirations for this category
     */
    public function aspirations()
    {
        return $this->hasMany(Aspiration::class);
    }
}
