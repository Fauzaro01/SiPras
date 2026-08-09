<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAspirationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $aspiration = $this->route('aspiration');

        return $aspiration && (auth()->user()->isAdmin() || $aspiration->user_id === auth()->id());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'lokasi' => ['required', 'string', 'max:255'],
            'bukti_foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'priority' => ['nullable', Rule::in(['rendah', 'sedang', 'tinggi', 'mendesak'])],
        ];
    }
}
