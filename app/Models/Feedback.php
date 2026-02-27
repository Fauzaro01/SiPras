<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'aspiration_id',
        'user_id',
        'pesan',
    ];

    /**
     * Get the aspiration that owns the feedback
     */
    public function aspiration()
    {
        return $this->belongsTo(Aspiration::class);
    }

    /**
     * Get the admin who gave the feedback
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
