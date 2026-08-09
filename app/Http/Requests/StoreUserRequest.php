<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,siswa',
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ];

        if ($this->input('role') === 'admin') {
            $rules['username'] = 'required|string|max:50|unique:users,username';
        } else {
            $rules['nis'] = 'required|string|max:20|unique:users,nis';
            $rules['kelas'] = 'nullable|string|max:50';
        }

        return $rules;
    }
}
