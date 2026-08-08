<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user)
    {
        ActivityLog::create([
            'user_id' => Auth::id() ?? $user->id,
            'loggable_type' => User::class,
            'loggable_id' => $user->id,
            'action' => 'created',
            'changes' => $user->only(['name', 'username', 'role', 'nis', 'kelas']),
        ]);
    }

    public function updated(User $user)
    {
        $changes = [];
        foreach ($user->getDirty() as $key => $value) {
            if ($key !== 'updated_at' && $key !== 'password') {
                $changes[$key] = [
                    'old' => $user->getOriginal($key),
                    'new' => $value
                ];
            }
        }

        if (!empty($changes)) {
            ActivityLog::create([
                'user_id' => Auth::id() ?? $user->id,
                'loggable_type' => User::class,
                'loggable_id' => $user->id,
                'action' => 'updated',
                'changes' => $changes,
            ]);
        }
    }

    public function deleted(User $user)
    {
        ActivityLog::create([
            'user_id' => Auth::id() ?? $user->id,
            'loggable_type' => User::class,
            'loggable_id' => $user->id,
            'action' => 'deleted',
            'changes' => $user->only(['name', 'username', 'role']),
        ]);
    }
}
