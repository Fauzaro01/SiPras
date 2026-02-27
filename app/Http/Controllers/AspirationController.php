<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspirationController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $aspirations = Aspiration::with(['user', 'category'])
                ->whereIn('status', ['diajukan', 'diproses'])
                ->orderByRaw("CASE WHEN status = 'diajukan' THEN 0 WHEN status = 'diproses' THEN 1 ELSE 2 END")
                ->latest()
                ->get();
        } else {
            $aspirations = Auth::user()->aspirations()->with('category')
                ->whereNotIn('status', ['selesai', 'ditolak'])
                ->latest()->get();
        }
        
        return view('aspirations.index', compact('aspirations'));
    }

    public function histori()
    {
        if (Auth::user()->isAdmin()) {
            $aspirations = Aspiration::with(['user', 'category', 'feedbacks'])
                ->whereIn('status', ['selesai', 'ditolak'])
                ->latest()->get();
        } else {
            $aspirations = Auth::user()->aspirations()->with(['category', 'feedbacks'])
                ->whereIn('status', ['selesai', 'ditolak'])
                ->latest()->get();
        }

        return view('aspirations.histori', compact('aspirations'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('aspirations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'lokasi'      => 'required|string|max:255',
            'bukti_foto'  => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['user_id']    = Auth::id();
        $validated['status']     = 'diajukan';
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

        $aspiration->load(['user', 'category', 'feedbacks.user']);
        return view('aspirations.show', compact('aspiration'));
    }

    public function updateStatus(Request $request, Aspiration $aspiration)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:diajukan,diproses,selesai,ditolak',
        ]);

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
