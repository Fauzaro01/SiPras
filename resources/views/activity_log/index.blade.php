@extends('layouts.dashboard')

@section('title', 'Audit Trail Log Aktivitas - SiPras')
@section('page-title', 'Audit Trail Log Aktivitas')

@section('content')
<div class="space-y-6">

    {{-- Stats Cards / Overview --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Log</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $logs->total() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Aksi Pembaruan</p>
                <p class="text-2xl font-bold text-yellow-600 mt-1">
                    {{ \App\Models\ActivityLog::where('action', 'updated')->count() }}
                </p>
            </div>
            <div class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5"/>
                </svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Aksi Penghapusan</p>
                <p class="text-2xl font-bold text-red-650 mt-1">
                    {{ \App\Models\ActivityLog::where('action', 'deleted')->count() }}
                </p>
            </div>
            <div class="w-10 h-10 bg-red-50 text-red-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <form method="GET" action="{{ route('activity-logs.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <div>
                <label for="search" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Cari Operator</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition"
                    placeholder="Nama / Username...">
            </div>
            <div>
                <label for="type" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tipe Objek</label>
                <select name="type" id="type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition bg-white">
                    <option value="">Semua Objek</option>
                    <option value="aspiration" {{ request('type') == 'aspiration' ? 'selected' : '' }}>Aspirasi</option>
                    <option value="comment" {{ request('type') == 'comment' ? 'selected' : '' }}>Komentar</option>
                    <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Pengguna</option>
                </select>
            </div>
            <div>
                <label for="action" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Aksi</label>
                <select name="action" id="action"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition bg-white">
                    <option value="">Semua Aksi</option>
                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Buat (Created)</option>
                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Ubah (Updated)</option>
                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Hapus (Deleted)</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition shadow-sm hover:shadow">
                    Filter
                </button>
                <a href="{{ route('activity-logs.index') }}"
                    class="bg-gray-150 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm transition text-center flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Log Table Card --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Operator</th>
                        <th class="px-6 py-4">Aksi</th>
                        <th class="px-6 py-4">Objek</th>
                        <th class="px-6 py-4">Detail Perubahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400">
                                {{ $log->created_at->format('d M Y, H:i:s') }}
                                <br>
                                <span class="text-[10px]">{{ $log->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-gray-800">{{ $log->user->name ?? 'Sistem' }}</div>
                                <div class="text-xs text-gray-400">{{ $log->user->role ?? '-' }} &middot; {{ $log->user->username ?? $log->user->nis ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $actionBadge = match($log->action) {
                                        'created' => 'bg-green-50 text-green-700 border-green-200/50',
                                        'updated' => 'bg-yellow-50 text-yellow-700 border-yellow-200/50',
                                        'deleted' => 'bg-red-50 text-red-700 border-red-200/50',
                                        default => 'bg-gray-50 text-gray-700 border-gray-200/50',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 border rounded-full text-xs font-semibold {{ $actionBadge }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                <span class="font-mono text-gray-600">
                                    {{ class_basename($log->loggable_type) }} #{{ $log->loggable_id }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->action === 'updated' && is_array($log->changes))
                                    <div class="space-y-1.5 max-w-md">
                                        @foreach($log->changes as $field => $change)
                                            <div class="text-xs">
                                                <span class="font-semibold text-gray-700">{{ $field }}</span>: 
                                                <span class="text-red-500 bg-red-50 px-1 rounded line-through">
                                                    {{ is_array($change['old'] ?? '') ? json_encode($change['old']) : ($change['old'] ?? 'NULL') }}
                                                </span>
                                                <span class="text-gray-400 mx-1">&rarr;</span>
                                                <span class="text-green-600 bg-green-50 px-1 rounded font-medium">
                                                    {{ is_array($change['new'] ?? '') ? json_encode($change['new']) : ($change['new'] ?? 'NULL') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($log->action === 'created' && is_array($log->changes))
                                    <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ json_encode($log->changes) }}">
                                        @foreach($log->changes as $key => $val)
                                            <span class="font-semibold">{{ $key }}</span>: {{ is_array($val) ? json_encode($val) : $val }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </div>
                                @elseif($log->action === 'deleted' && is_array($log->changes))
                                    <div class="text-xs text-red-500 bg-red-50/50 p-2 rounded max-w-xs">
                                        Data Terhapus: 
                                        @foreach($log->changes as $key => $val)
                                            <span class="font-medium">{{ $key }}</span>: {{ is_array($val) ? json_encode($val) : $val }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-450">-</span>
                                @endif
                            </td>
                        </tr>
                    @forelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
