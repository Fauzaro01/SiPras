<?php

namespace App\Listeners;

use App\Events\AspirationStatusUpdated;
use App\Models\Notification;

class NotifyUserStatusChange
{
    public function handle(AspirationStatusUpdated $event)
    {
        $user = $event->aspiration->user;
        if ($user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'status_change',
                'data' => [
                    'aspiration_id' => $event->aspiration->id,
                    'title' => $event->aspiration->judul,
                    'old_status' => $event->oldStatus,
                    'new_status' => $event->newStatus,
                ],
            ]);
        }
    }
}
