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

    public function rules(): array
    {
        $user = $this->route('user');

        $rules = [
            'name' => 'required|string|max:255',
        ];

        if ($user && $user->role === 'admin') {
            $rules['username'] = 'required|string|max:50|unique:users,username,'.$user->id;
        } else {
            $rules['nis'] = 'required|string|max:20|unique:users,nis,'.($user ? $user->id : 'NULL');
            $rules['kelas'] = 'nullable|string|max:50';
        }

        if ($this->filled('password')) {
            $rules['password'] = ['string', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()];
        }

        return $rules;
    }
}
