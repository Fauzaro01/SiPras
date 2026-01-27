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
                'pending' => Aspiration::where('status', 'pending')->count(),
                'diproses' => Aspiration::where('status', 'diproses')->count(),
                'selesai' => Aspiration::where('status', 'selesai')->count(),
            ];
            $recent_aspirations = Aspiration::with('user')->latest()->take(5)->get();
        } else {
            $stats = [
                'total_aspirasi' => $user->aspirations()->count(),
                'pending' => $user->aspirations()->where('status', 'pending')->count(),
                'diproses' => $user->aspirations()->where('status', 'diproses')->count(),
                'selesai' => $user->aspirations()->where('status', 'selesai')->count(),
            ];
            $recent_aspirations = $user->aspirations()->latest()->take(5)->get();
        }

        return view('dashboard', compact('stats', 'recent_aspirations'));
    }
}
