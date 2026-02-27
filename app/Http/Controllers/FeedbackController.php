<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Simpan feedback baru untuk sebuah aspirasi (hanya admin)
     */
    public function store(Request $request, Aspiration $aspiration)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'pesan' => 'required|string',
        ]);

        $aspiration->feedbacks()->create([
            'user_id' => Auth::id(),
            'pesan'   => $validated['pesan'],
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil ditambahkan!');
    }

    /**
     * Hapus feedback (hanya admin)
     */
    public function destroy(Aspiration $aspiration, Feedback $feedback)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($feedback->aspiration_id !== $aspiration->id) {
            abort(404);
        }

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback berhasil dihapus!');
    }
}
