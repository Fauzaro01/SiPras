<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $user = $this->route('user');

        $rules = [
            'name' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:50',
            'nis' => 'nullable|string|max:20|unique:users,nis,'.$user->id,
        ];

        if ($this->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        return $rules;
    }
}
