<?php

namespace App\Observers;

use App\Models\Aspiration;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AspirationObserver
{
    public function created(Aspiration $aspiration)
    {
        \Illuminate\Support\Facades\Cache::flush();

        ActivityLog::create([
            'user_id' => Auth::id() ?? $aspiration->user_id,
            'loggable_type' => Aspiration::class,
            'loggable_id' => $aspiration->id,
            'action' => 'created',
            'changes' => $aspiration->only(['judul', 'lokasi', 'priority', 'status']),
        ]);

        event(new \App\Events\AspirationCreated($aspiration));
    }

    public function updated(Aspiration $aspiration)
    {
        \Illuminate\Support\Facades\Cache::flush();

        $changes = [];
        foreach ($aspiration->getDirty() as $key => $value) {
            if ($key !== 'updated_at') {
                $changes[$key] = [
                    'old' => $aspiration->getOriginal($key),
                    'new' => $value
                ];
            }
        }

        if (!empty($changes)) {
            ActivityLog::create([
                'user_id' => Auth::id() ?? $aspiration->user_id,
                'loggable_type' => Aspiration::class,
                'loggable_id' => $aspiration->id,
                'action' => 'updated',
                'changes' => $changes,
            ]);

            if (isset($changes['status'])) {
                event(new \App\Events\AspirationStatusUpdated(
                    $aspiration,
                    $changes['status']['old'],
                    $changes['status']['new']
                ));
            }
        }
    }

    public function deleted(Aspiration $aspiration)
    {
        \Illuminate\Support\Facades\Cache::flush();

        ActivityLog::create([
            'user_id' => Auth::id() ?? $aspiration->user_id,
            'loggable_type' => Aspiration::class,
            'loggable_id' => $aspiration->id,
            'action' => 'deleted',
            'changes' => $aspiration->only(['judul', 'status']),
        ]);
    }
}
