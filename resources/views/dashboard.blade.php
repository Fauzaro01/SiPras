@extends('layouts.dashboard')

@section('title', 'Dashboard - SiPras')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-blue-100">
            @if(Auth::user()->isAdmin())
                Anda login sebagai Admin - Kelola semua aspirasi prasarana sekolah
            @else
                NIS: {{ Auth::user()->nis }} | Kelas: {{ Auth::user()->kelas ?? '-' }}
            @endif
        </p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Aspirasi</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_aspirasi'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Diproses</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['diproses'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Selesai</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['selesai'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Aspirations -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Aspirasi Terbaru</h2>
            <a href="{{ route('aspirations.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="p-6">
            @if($recent_aspirations->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_aspirations as $aspiration)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $aspiration->judul }}</h3>
                                    @if(Auth::user()->isAdmin())
                                        <p class="text-sm text-gray-600 mt-1">Oleh: {{ $aspiration->user->name }} ({{ $aspiration->user->nis }})</p>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-1">{{ $aspiration->kategori }} - {{ $aspiration->lokasi }}</p>
                                    <p class="text-xs text-gray-400 mt-2">{{ $aspiration->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $aspiration->status_color }}">
                                    {{ ucfirst($aspiration->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2">Belum ada aspirasi</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
