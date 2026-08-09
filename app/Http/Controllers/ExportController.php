<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Ekspor daftar aspirasi ke CSV dengan filter
     */
    public function exportCsv(Request $request)
    {
        $query = Aspiration::query()->with(['user', 'category']);

        // Filter
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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $aspirations = $query->latest()->get();

        $filename = "aspirasi_export_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = ['ID', 'Judul', 'Deskripsi', 'Lokasi', 'Kategori', 'Pelapor (NIS)', 'Status', 'Prioritas', 'Tanggal Pengajuan'];

        $callback = function () use ($aspirations, $columns) {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel alignment
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, $columns);

            foreach ($aspirations as $aspiration) {
                fputcsv($file, [
                    $aspiration->id,
                    $aspiration->judul,
                    $aspiration->deskripsi,
                    $aspiration->lokasi,
                    $aspiration->category->nama ?? '-',
                    ($aspiration->user->name ?? '-') . ' (' . ($aspiration->user->nis ?? '-') . ')',
                    $aspiration->status_label,
                    str_replace(['🟢 ', '🟡 ', '🟠 ', '🔴 '], '', $aspiration->priority_label),
                    $aspiration->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ekspor daftar aspirasi ke PDF dengan filter
     */
    public function exportPdf(Request $request)
    {
        $query = Aspiration::query()->with(['user', 'category']);

        // Filter (same as CSV)
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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $aspirations = $query->latest()->get();
        $filename    = "aspirasi_export_" . date('Ymd_His') . ".pdf";

        $pdf = Pdf::loadView('exports.aspiration_pdf', compact('aspirations'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}
