<?php

namespace App\Observers;

use App\Events\AspirationCreated;
use App\Events\AspirationStatusUpdated;
use App\Models\ActivityLog;
use App\Models\Aspiration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AspirationObserver
{
    public function created(Aspiration $aspiration)
    {
        Cache::flush();

        ActivityLog::create([
            'user_id' => Auth::id() ?? $aspiration->user_id,
            'loggable_type' => Aspiration::class,
            'loggable_id' => $aspiration->id,
            'action' => 'created',
            'changes' => $aspiration->only(['judul', 'lokasi', 'priority', 'status']),
        ]);

        event(new AspirationCreated($aspiration));
    }

    public function updated(Aspiration $aspiration)
    {
        Cache::flush();

        $changes = [];
        foreach ($aspiration->getDirty() as $key => $value) {
            if ($key !== 'updated_at') {
                $changes[$key] = [
                    'old' => $aspiration->getOriginal($key),
                    'new' => $value,
                ];
            }
        }

        if (! empty($changes)) {
            ActivityLog::create([
                'user_id' => Auth::id() ?? $aspiration->user_id,
                'loggable_type' => Aspiration::class,
                'loggable_id' => $aspiration->id,
                'action' => 'updated',
                'changes' => $changes,
            ]);

            if (isset($changes['status'])) {
                event(new AspirationStatusUpdated(
                    $aspiration,
                    $changes['status']['old'],
                    $changes['status']['new']
                ));
            }
        }
    }

    public function deleted(Aspiration $aspiration)
    {
        Cache::flush();

        ActivityLog::create([
            'user_id' => Auth::id() ?? $aspiration->user_id,
            'loggable_type' => Aspiration::class,
            'loggable_id' => $aspiration->id,
            'action' => 'deleted',
            'changes' => $aspiration->only(['judul', 'status']),
        ]);
    }
}
