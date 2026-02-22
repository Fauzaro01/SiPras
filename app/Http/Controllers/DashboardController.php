<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspiration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $stats = [
                'total_aspirasi' => Aspiration::count(),
                'diproses' => Aspiration::where('status', 'diproses')->count(),
                'selesai' => Aspiration::where('status', 'selesai')->count(),
                'ditolak' => Aspiration::where('status', 'ditolak')->count(),
            ];
            $recent_aspirations = Aspiration::with(['user', 'category'])->latest()->take(5)->get();
        } else {
            $stats = [
                'total_aspirasi' => $user->aspirations()->count(),
                'diproses' => $user->aspirations()->where('status', 'diproses')->count(),
                'selesai' => $user->aspirations()->where('status', 'selesai')->count(),
                'ditolak' => $user->aspirations()->where('status', 'ditolak')->count(),
            ];
            $recent_aspirations = $user->aspirations()->with('category')->latest()->take(5)->get();
        }

        return view('dashboard', compact('stats', 'recent_aspirations'));
    }
}
