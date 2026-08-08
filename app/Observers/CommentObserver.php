<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class CommentObserver
{
    public function created(Comment $comment)
    {
        ActivityLog::create([
            'user_id' => Auth::id() ?? $comment->user_id,
            'loggable_type' => Comment::class,
            'loggable_id' => $comment->id,
            'action' => 'created',
            'changes' => [
                'aspiration_id' => $comment->aspiration_id,
                'content_preview' => \Illuminate\Support\Str::limit($comment->content, 50),
            ],
        ]);
    }

    public function deleted(Comment $comment)
    {
        ActivityLog::create([
            'user_id' => Auth::id() ?? $comment->user_id,
            'loggable_type' => Comment::class,
            'loggable_id' => $comment->id,
            'action' => 'deleted',
            'changes' => [
                'aspiration_id' => $comment->aspiration_id,
                'content_preview' => \Illuminate\Support\Str::limit($comment->content, 50),
            ],
        ]);
    }
}
