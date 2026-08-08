@extends('layouts.dashboard')

@section('title', 'Hasil Pencarian - SiPras')
@section('page-title', 'Hasil Pencarian')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Hasil Pencarian untuk: <span class="text-blue-600">"{{ $query }}"</span></h1>
        <p class="text-gray-500 text-sm mt-1">Ditemukan {{ $aspirations->count() + $categories->count() + $users->count() }} hasil</p>
    </div>

    {{-- Aspirations Results --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <h2 class="text-base sm:text-lg font-bold text-gray-800">Aspirasi ({{ $aspirations->count() }})</h2>
        </div>
        <div class="p-4 sm:p-6">
            @if($aspirations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($aspirations as $aspiration)
                        <a href="{{ route('aspirations.show', $aspiration) }}" class="block border border-gray-100 hover:border-blue-300 rounded-xl p-4 hover:shadow-md transition duration-200">
                            <div class="flex justify-between items-start gap-2">
                                <div class="space-y-1 min-w-0">
                                    <h3 class="font-bold text-gray-800 truncate text-sm">{{ $aspiration->judul }}</h3>
                                    <p class="text-xs text-gray-500 truncate">{{ $aspiration->category->nama ?? '-' }} &middot; {{ $aspiration->lokasi }}</p>
                                    <p class="text-[11px] text-gray-400">Dilaporkan {{ $aspiration->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $aspiration->status_color }}">
                                        {{ $aspiration->status_label }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $aspiration->priority_color }}">
                                        {{ $aspiration->priority_label }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">Tidak ada aspirasi yang cocok.</p>
            @endif
        </div>
    </div>

    {{-- Categories Results --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <h2 class="text-base sm:text-lg font-bold text-gray-800">Kategori ({{ $categories->count() }})</h2>
        </div>
        <div class="p-4 sm:p-6">
            @if($categories->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($categories as $category)
                        <div class="border border-gray-100 rounded-xl p-4">
                            <h3 class="font-bold text-gray-800 text-sm">📁 {{ $category->nama }}</h3>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $category->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">Tidak ada kategori yang cocok.</p>
            @endif
        </div>
    </div>

    {{-- Users Results (Admin only) --}}
    @if(Auth::user()->isAdmin())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-gray-100">
                <h2 class="text-base sm:text-lg font-bold text-gray-800">Pengguna / Siswa ({{ $users->count() }})</h2>
            </div>
            <div class="p-4 sm:p-6">
                @if($users->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($users as $usr)
                            <div class="border border-gray-100 rounded-xl p-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center flex-shrink-0 text-sm">
                                    {{ strtoupper(substr($usr->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-gray-800 text-xs truncate">{{ $usr->name }}</h3>
                                    <p class="text-[10px] text-gray-500 truncate">{{ ucfirst($usr->role) }} &middot; {{ $usr->nis ?? $usr->username }}</p>
                                    @if($usr->kelas)
                                        <p class="text-[10px] text-gray-400">Kelas: {{ $usr->kelas }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-sm">Tidak ada pengguna yang cocok.</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
