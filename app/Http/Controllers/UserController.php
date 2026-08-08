<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->withCount('aspirations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $stats = [
            'total' => User::count(),
            'siswa' => User::where('role', 'siswa')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('users.index', compact('users', 'stats'));
    }

    // Show profile edit form for authenticated user
    public function editProfile()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // Update authenticated user's profile
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        // Handle avatar upload if present
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        // Update password if provided (already hashed in request)
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

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
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // Delete all aspiration photos for this user in a batch query
        $photos = $user->aspirations()
            ->whereNotNull('bukti_foto')
            ->pluck('bukti_foto')
            ->toArray();

        if (! empty($photos)) {
            Storage::disk('public')->delete($photos);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
