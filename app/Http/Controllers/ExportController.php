<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportCsv(Request $request)
    {
        // Admin only authorization
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $query = Aspiration::query()->with(['user', 'category']);

        // Apply filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $aspirations = $query->latest()->get();

        $filename = 'rekap_aspirasi_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use($aspirations) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper Excel opening
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'ID',
                'Judul',
                'Kategori',
                'Deskripsi',
                'Lokasi',
                'Prioritas',
                'Status',
                'Pelapor (Nama)',
                'Pelapor (NIS)',
                'Pelapor (Kelas)',
                'Tanggal Diajukan',
                'Terakhir Diperbarui'
            ], ';');

            foreach ($aspirations as $asp) {
                fputcsv($file, [
                    $asp->id,
                    $asp->judul,
                    $asp->category->nama ?? '-',
                    $asp->deskripsi,
                    $asp->lokasi,
                    $asp->priority_label,
                    $asp->status_label,
                    $asp->user->name ?? '-',
                    $asp->user->nis ?? '-',
                    $asp->user->kelas ?? '-',
                    $asp->created_at->format('Y-m-d H:i:s'),
                    $asp->updated_at->format('Y-m-d H:i:s')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
