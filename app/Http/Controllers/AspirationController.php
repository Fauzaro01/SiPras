<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAspirationRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $validated['bukti_foto'] = $request->file('bukti_foto')->store('bukti_foto', 'public');

        Aspiration::create($validated);

        return redirect()->route('aspirations.index')
            ->with('success', 'Aspirasi berhasil dibuat!');
    }

    public function show(Aspiration $aspiration)
    {
        if (Auth::user()->isSiswa() && $aspiration->user_id !== Auth::id()) {
            abort(403);
        }

        $aspiration->load(['user', 'category', 'feedbacks' => fn ($q) => $q->latest(), 'feedbacks.user']);

        return view('aspirations.show', compact('aspiration'));
    }

    public function updateStatus(UpdateStatusRequest $request, Aspiration $aspiration)
    {
        $validated = $request->validated();

        $aspiration->update($validated);

        return redirect()->back()
            ->with('success', 'Status aspirasi berhasil diupdate!');
    }

    public function destroy(Aspiration $aspiration)
    {
        if (Auth::user()->isSiswa() && $aspiration->user_id !== Auth::id()) {
            abort(403);
        }

        if ($aspiration->bukti_foto) {
            Storage::disk('public')->delete($aspiration->bukti_foto);
        }

        $aspiration->delete();

        return redirect()->route('aspirations.index')
            ->with('success', 'Aspirasi berhasil dihapus!');
    }
}
