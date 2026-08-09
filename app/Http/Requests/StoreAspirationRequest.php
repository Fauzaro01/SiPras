<?php

namespace App\Http\Requests;

use App\Models\Aspiration;
use Illuminate\Foundation\Http\FormRequest;

class StoreAspirationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * F-11: Batasi maksimal 3 aspirasi aktif (diajukan/diproses) per siswa.
     */
    public function authorize(): bool
    {
        if (! $this->user()->isSiswa()) {
            return false;
        }

        $activeCount = Aspiration::where('user_id', $this->user()->id)
            ->whereIn('status', ['diajukan', 'diproses'])
            ->count();

        if ($activeCount >= 3) {
            abort(422, 'Kamu sudah memiliki 3 aspirasi aktif. Tunggu hingga salah satu selesai atau ditolak sebelum membuat yang baru.');
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'lokasi' => 'required|string|max:255',
            'bukti_foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'priority' => 'nullable|in:rendah,sedang,tinggi,mendesak', // F-08
        ];
    }
}
