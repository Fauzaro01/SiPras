<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Return the latest 20 notifications for the authenticated user as JSON.
     */
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        return response()->json($notifications);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        // Ensure the notification belongs to the user
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }
        $notification->update(['read_at' => now()]);
        return response()->json(['status' => 'ok']);
    }

    /**
     * Mark all notifications for the user as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->notifications()->update(['read_at' => now()]);
        return response()->json(['status' => 'ok']);
    }
}
