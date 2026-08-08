<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        if (empty($query)) {
            return redirect()->route('dashboard');
        }

        $user = Auth::user();

        // 1. Search Aspirations
        $aspirationQuery = Aspiration::query()->with(['user', 'category']);
        if ($user->isSiswa()) {
            $aspirationQuery->where('user_id', $user->id);
        }
        $aspirations = $aspirationQuery->where(function ($q) use ($query) {
            $q->where('judul', 'like', "%{$query}%")
                ->orWhere('deskripsi', 'like', "%{$query}%")
                ->orWhere('lokasi', 'like', "%{$query}%");
        })->latest()->take(10)->get();

        // 2. Search Categories
        $categories = Category::where('nama', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->latest()->take(5)->get();

        // 3. Search Users (Admin only)
        $users = collect();
        if ($user->isAdmin()) {
            $users = User::where('name', 'like', "%{$query}%")
                ->orWhere('username', 'like', "%{$query}%")
                ->orWhere('nis', 'like', "%{$query}%")
                ->orWhere('kelas', 'like', "%{$query}%")
                ->latest()->take(10)->get();
        }

        return view('search', compact('query', 'aspirations', 'categories', 'users'));
    }
}
