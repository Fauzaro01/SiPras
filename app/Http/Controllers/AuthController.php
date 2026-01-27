<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = $credentials['identifier'];
        $password = $credentials['password'];

        // Coba login sebagai admin (username) atau siswa (NIS)
        $user = User::where('username', $identifier)
            ->orWhere('nis', $identifier)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')
                ->with('success', 'Selamat datang, ' . $user->name);
        }

        return back()->withErrors([
            'identifier' => 'Username/NIS atau password salah.',
        ])->onlyInput('identifier');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
