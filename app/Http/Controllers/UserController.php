<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $users = User::withCount('aspirations')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $rules = [
            'name'     => 'required|string|max:255',
            'role'     => 'required|in:admin,siswa',
            'password' => 'required|string|min:6|confirmed',
        ];

        if ($request->role === 'admin') {
            $rules['username'] = 'required|string|max:50|unique:users,username';
        } else {
            $rules['nis']   = 'required|string|max:20|unique:users,nis';
            $rules['kelas'] = 'nullable|string|max:50';
        }

        $validated = $request->validate($rules);
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $rules = [
            'name'  => 'required|string|max:255',
            'kelas' => 'nullable|string|max:50',
            'nis'   => 'nullable|string|max:20|unique:users,nis,' . $user->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // Delete all aspiration photos for this user
        foreach ($user->aspirations as $aspiration) {
            if ($aspiration->bukti_foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($aspiration->bukti_foto);
            }
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
