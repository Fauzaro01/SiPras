<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirationController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $aspirations = Aspiration::with('user')->latest()->paginate(10);
        } else {
            $aspirations = Auth::user()->aspirations()->latest()->paginate(10);
        }
        
        return view('aspirations.index', compact('aspirations'));
    }

    public function create()
    {
        return view('aspirations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'lokasi' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        Aspiration::create($validated);

        return redirect()->route('aspirations.index')
            ->with('success', 'Aspirasi berhasil dibuat!');
    }

    public function show(Aspiration $aspiration)
    {
        // Pastikan siswa hanya bisa lihat aspirasinya sendiri
        if (Auth::user()->isSiswa() && $aspiration->user_id !== Auth::id()) {
            abort(403);
        }

        return view('aspirations.show', compact('aspiration'));
    }

    public function updateStatus(Request $request, Aspiration $aspiration)
    {
        // Hanya admin yang bisa update status
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'tanggapan_admin' => 'nullable|string',
        ]);

        $aspiration->update($validated);

        return redirect()->back()
            ->with('success', 'Status aspirasi berhasil diupdate!');
    }

    public function destroy(Aspiration $aspiration)
    {
        // Siswa hanya bisa hapus aspirasinya sendiri
        if (Auth::user()->isSiswa() && $aspiration->user_id !== Auth::id()) {
            abort(403);
        }

        $aspiration->delete();

        return redirect()->route('aspirations.index')
            ->with('success', 'Aspirasi berhasil dihapus!');
    }
}
