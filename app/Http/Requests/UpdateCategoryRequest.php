<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $category = $this->route('category');
        $id = $category ? $category->id : null;

        return [
            'nama' => 'required|string|max:255|unique:categories,nama,'.$id,
            'deskripsi' => 'nullable|string|max:255',
        ];
    }
}
