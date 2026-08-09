<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Aspiration;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    /**
     * Simpan feedback baru untuk sebuah aspirasi (hanya admin)
     */
    public function store(StoreFeedbackRequest $request, Aspiration $aspiration)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }
        $validated = $request->validated();

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
