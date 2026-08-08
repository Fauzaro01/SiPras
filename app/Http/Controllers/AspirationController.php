<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAspirationRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class AspirationController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama')->get();

        $query = Aspiration::query()->with(['user', 'category']);

        if (Auth::user()->isAdmin()) {
            $query->whereIn('status', ['diajukan', 'diproses']);
        } else {
            $query->where('user_id', Auth::id())
                ->whereNotIn('status', ['selesai', 'ditolak']);
        }

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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%");
                    });
            });
        }

        if (Auth::user()->isAdmin()) {
            $query->orderByRaw("CASE WHEN status = 'diajukan' THEN 0 WHEN status = 'diproses' THEN 1 ELSE 2 END")
                ->latest();
        } else {
            $query->latest();
        }

        $aspirations = $query->paginate(15)->withQueryString();

        return view('aspirations.index', compact('aspirations', 'categories'));
    }

    public function histori(Request $request)
    {
        $categories = Category::orderBy('nama')->get();

        $query = Aspiration::query()->with(['user', 'category', 'feedbacks']);

        if (Auth::user()->isAdmin()) {
            $query->whereIn('status', ['selesai', 'ditolak']);
        } else {
            $query->where('user_id', Auth::id())
                ->whereIn('status', ['selesai', 'ditolak']);
        }

        // Hitung stats absolut sebelum filtering pencarian
        $statsQuery = Aspiration::query();
        if (! Auth::user()->isAdmin()) {
            $statsQuery->where('user_id', Auth::id());
        }
        $stats = [
            'selesai' => (clone $statsQuery)->where('status', 'selesai')->count(),
            'ditolak' => (clone $statsQuery)->where('status', 'ditolak')->count(),
        ];

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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%");
                    });
            });
        }

        $aspirations = $query->latest()->paginate(15)->withQueryString();

        return view('aspirations.histori', compact('aspirations', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();

        return view('aspirations.create', compact('categories'));
    }

    public function store(StoreAspirationRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'diajukan';
        
        $file = $request->file('bukti_foto');
        $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
        $validated['bukti_foto'] = $file->storeAs('bukti_foto', $filename, 'public');

        Aspiration::create($validated);

        return redirect()->route('aspirations.index')
            ->with('success', 'Aspirasi berhasil dibuat!');
    }

    public function show(Aspiration $aspiration)
    {
        if (Auth::user()->isSiswa() && $aspiration->user_id !== Auth::id()) {
            abort(403);
        }

        $aspiration->load([
            'user',
            'category',
            'feedbacks' => fn ($q) => $q->whereNull('parent_id')->latest(),
            'feedbacks.user',
            'feedbacks.replies' => fn ($q) => $q->oldest(), // sort replies chronologically
            'feedbacks.replies.user',
            'comments' => fn ($q) => $q->oldest(),
            'comments.user',
        ]);

        return view('aspirations.show', compact('aspiration'));
    }

    public function updateStatus(UpdateStatusRequest $request, Aspiration $aspiration)
    {
        $validated = $request->validated();

        $aspiration->update($validated);

        if ($aspiration->user && !empty($aspiration->user->email)) {
            \Illuminate\Support\Facades\Mail::to($aspiration->user->email)
                ->send(new \App\Mail\AspirationStatusChanged($aspiration));
        }

        return redirect()->back()
            ->with('success', 'Status aspirasi berhasil diupdate!');
    }

    public function destroy(Aspiration $aspiration)
    {
        if (Auth::user()->isSiswa() && $aspiration->user_id !== Auth::id()) {
            abort(403);
        }

        // B-06: Hanya aspirasi berstatus 'diajukan' yang boleh dihapus
        if (Auth::user()->isSiswa() && $aspiration->status !== 'diajukan') {
            return redirect()->route('aspirations.index')
                ->with('error', 'Aspirasi yang sudah diproses atau selesai tidak dapat dihapus.');
        }

        if ($aspiration->bukti_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($aspiration->bukti_foto)) {
            Storage::disk('public')->delete($aspiration->bukti_foto);
        }

        $aspiration->delete();

        return redirect()->route('aspirations.index')
            ->with('success', 'Aspirasi berhasil dihapus.');
    }
}
