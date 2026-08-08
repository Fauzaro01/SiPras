<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Simpan feedback baru untuk sebuah aspirasi (hanya admin)
     */
    public function store(Request $request, Aspiration $aspiration)
    {
        // F-13: Authorize admin OR the owner of the aspiration
        if (!auth()->user()->isAdmin() && $aspiration->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke aspirasi ini.');
        }

        $validated = $request->validate([
            'pesan' => 'required|string',
            'parent_id' => 'nullable|exists:feedbacks,id', // F-13: untuk reply
        ]);

        // F-13: Pastikan feedback parent milik aspirasi yang sama
        if (!empty($validated['parent_id'])) {
            $parentExists = Feedback::where('id', $validated['parent_id'])
                ->where('aspiration_id', $aspiration->id)
                ->exists();
            if (!$parentExists) {
                abort(400, 'Feedback parent tidak valid.');
            }
        }

        $aspiration->feedbacks()->create([
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => auth()->id(),
            'pesan' => $validated['pesan'],
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil ditambahkan!');
    }

    /**
     * Hapus feedback (hanya admin)
     */
    public function destroy(Aspiration $aspiration, Feedback $feedback)
    {
        if ($feedback->aspiration_id !== $aspiration->id) {
            abort(404);
        }

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback berhasil dihapus!');
    }
}
