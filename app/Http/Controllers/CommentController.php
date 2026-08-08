<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Simpan komentar baru untuk sebuah aspirasi.
     */
    public function store(Request $request, Aspiration $aspiration)
    {
        // Pastikan siswa hanya bisa mengomentari aspirasi milik sendiri
        if (auth()->user()->isSiswa() && $aspiration->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke aspirasi ini.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $aspiration->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Hapus komentar (pemilik komentar atau admin).
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
