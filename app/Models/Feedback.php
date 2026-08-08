<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'parent_id', // F-13: untuk reply
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

    // ── F-13: Threading ──────────────────────────────────────

    /**
     * Get replies to this feedback (siswa membalas admin)
     */
    public function replies()
    {
        return $this->hasMany(Feedback::class, 'parent_id')->with('user')->latest();
    }

    /**
     * Get the parent feedback (null if this is a top-level feedback)
     */
    public function parent()
    {
        return $this->belongsTo(Feedback::class, 'parent_id');
    }

    /**
     * Check if this is a top-level feedback (bukan reply)
     */
    public function isTopLevel(): bool
    {
        return is_null($this->parent_id);
    }
}
