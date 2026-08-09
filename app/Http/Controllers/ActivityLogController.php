<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Aspiration;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Tampilkan log aktivitas audit trail (hanya admin).
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with(['user']);

        // Filter berdasarkan aksi
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter berdasarkan tipe model
        if ($request->filled('type')) {
            $modelClass = match ($request->type) {
                'aspiration' => Aspiration::class,
                'comment' => Comment::class,
                'user' => User::class,
                default => null,
            };

            if ($modelClass) {
                $query->where('loggable_type', $modelClass);
            }
        }

        // Filter berdasarkan pencarian nama user
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest()->paginate(25)->withQueryString();

        return view('activity_log.index', compact('logs'));
    }
}
