<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAspirationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isSiswa();
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
        ];
    }
}
