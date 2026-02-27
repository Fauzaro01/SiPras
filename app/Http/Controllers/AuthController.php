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

    public function changePasswordForm()
    {
        return view('profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah!');
    }
}
