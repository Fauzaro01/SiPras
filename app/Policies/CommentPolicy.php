<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can view any comments.
     */
    public function viewAny(User $user)
    {
        return true; // all authenticated users can view comments
    }

    /**
     * Determine whether the user can view a comment.
     */
    public function view(User $user, Comment $comment)
    {
        return true; // all authenticated users can view
    }

    /**
     * Determine whether the user can create a comment.
     */
    public function create(User $user)
    {
        // Any authenticated user can comment on an aspiration they can see
        return $user->exists();
    }

    /**
     * Determine whether the user can delete the comment.
     * Only the comment owner or an admin can delete.
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->isAdmin() || $comment->user_id === $user->id;
    }
}
