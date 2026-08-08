<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cacheKey = "dashboard_data_user_" . $user->id;

        $data = \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function() use ($user) {
            // ── Scope query berdasarkan role ──────────────────────────────────
            $baseQuery = $user->isAdmin()
                ? Aspiration::query()
                : Aspiration::where('user_id', $user->id);

            // ── Statistik ringkasan (1 query) ─────────────────────────────────
            $counts = (clone $baseQuery)->selectRaw("
                COUNT(*) as total_aspirasi,
                SUM(CASE WHEN status = 'diajukan'  THEN 1 ELSE 0 END) as diajukan,
                SUM(CASE WHEN status = 'diproses'  THEN 1 ELSE 0 END) as diproses,
                SUM(CASE WHEN status = 'selesai'   THEN 1 ELSE 0 END) as selesai,
                SUM(CASE WHEN status = 'ditolak'   THEN 1 ELSE 0 END) as ditolak
            ")->first();

            $stats = [
                'total_aspirasi' => (int) ($counts->total_aspirasi ?? 0),
                'diajukan'       => (int) ($counts->diajukan ?? 0),
                'diproses'       => (int) ($counts->diproses ?? 0),
                'selesai'        => (int) ($counts->selesai ?? 0),
                'ditolak'        => (int) ($counts->ditolak ?? 0),
            ];

            // ── Tren bulanan 6 bulan terakhir (untuk line/bar chart) ──────────
            $rawMonthly = (clone $baseQuery)
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
                ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $chartMonths = [];
            $chartCounts = [];
            for ($i = 5; $i >= 0; $i--) {
                $key   = now()->subMonths($i)->format('Y-m');
                $label = now()->subMonths($i)->translatedFormat('M Y');
                $chartMonths[] = $label;
                $chartCounts[] = $rawMonthly[$key] ?? 0;
            }

            // ── Distribusi per kategori (untuk doughnut chart) ────────────────
            $categoryRows = (clone $baseQuery)
                ->selectRaw('category_id, COUNT(*) as count')
                ->groupBy('category_id')
                ->with('category')
                ->get();

            $chartCategories      = $categoryRows->map(fn ($r) => $r->category->nama ?? 'Umum')->toArray();
            $chartCategoryCounts  = $categoryRows->pluck('count')->toArray();

            // ── Aspirasi terbaru ──────────────────────────────────────────────
            $recent_aspirations = $user->isAdmin()
                ? Aspiration::with(['user', 'category'])->latest()->take(5)->get()
                : $user->aspirations()->with('category')->latest()->take(5)->get();

            return [
                'stats' => $stats,
                'recent_aspirations' => $recent_aspirations,
                'chartMonths' => $chartMonths,
                'chartCounts' => $chartCounts,
                'chartCategories' => $chartCategories,
                'chartCategoryCounts' => $chartCategoryCounts,
            ];
        });

        return view('dashboard', $data);
    }
}
