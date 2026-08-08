<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspiration_id',
        'user_id',
        'content',
    ];

    public function aspiration()
    {
        return $this->belongsTo(Aspiration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
