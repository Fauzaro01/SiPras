<?php

namespace App\Listeners;

use App\Events\AspirationCreated;
use App\Models\Notification;
use App\Models\User;

class NotifyAdminsNewAspiration
{
    public function handle(AspirationCreated $event)
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'new_aspiration',
                'data' => [
                    'aspiration_id' => $event->aspiration->id,
                    'title' => $event->aspiration->judul,
                ],
            ]);
        }
    }
}
