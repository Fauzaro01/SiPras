<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirationController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $aspirations = Aspiration::with(['user', 'category'])->latest()->get();
        } else {
            $aspirations = Auth::user()->aspirations()->with('category')->latest()->get();
        }
        
        return view('aspirations.index', compact('aspirations'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('aspirations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'lokasi' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        Aspiration::create($validated);

        return redirect()->route('aspirations.index')
            ->with('success', 'Aspirasi berhasil dibuat!');
    }

    public function show(Aspiration $aspiration)
    {
        if (Auth::user()->isSiswa() && $aspiration->user_id !== Auth::id()) {
            abort(403);
        }

        $aspiration->load(['user', 'category']);
        return view('aspirations.show', compact('aspiration'));
    }

    public function updateStatus(Request $request, Aspiration $aspiration)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:diproses,selesai,ditolak',
            'tanggapan_admin' => 'nullable|string',
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

        $aspiration->delete();

        return redirect()->route('aspirations.index')
            ->with('success', 'Aspirasi berhasil dihapus!');
    }
}
