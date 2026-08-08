@extends('layouts.dashboard')

@section('title', 'Daftar Aspirasi - SiPras')
@section('page-title', 'Aspirasi')

@push('styles')
<style>
    /* ── Length select ── */
    .dataTables_wrapper .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: #6b7280;
    }
    .dataTables_wrapper .dataTables_length select {
        padding: 8px 32px 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.85rem;
        background-color: #fff;
        color: #374151;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .dataTables_wrapper .dataTables_length select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,.12);
    }

    /* ── Search ── */
    .dt-search-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
    }
    .dt-search-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        pointer-events: none;
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }
    .dataTables_wrapper .dataTables_filter label {
        font-size: 0;
    }
    .dataTables_wrapper .dataTables_filter input {
        padding: 9px 14px 9px 36px !important;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.85rem !important;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, width 0.25s;
        width: 220px;
        background: #f9fafb;
        color: #374151;
        display: block;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,.12);
        background: #fff;
        width: 260px;
    }
    .dataTables_wrapper .dataTables_filter input::placeholder {
        color: #9ca3af;
    }

    /* ── Table ── */
    table.dataTable thead th {
        border-bottom: 2px solid #e5e7eb !important;
        padding: 12px 12px !important;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        color: #6b7280;
        text-transform: uppercase;
        white-space: nowrap;
    }
    table.dataTable thead th.sorting::after,
    table.dataTable thead th.sorting_asc::after,
    table.dataTable thead th.sorting_desc::after {
        opacity: 0.5;
    }
    table.dataTable tbody td {
        border-bottom: 1px solid #f3f4f6 !important;
        padding: 13px 12px !important;
        vertical-align: middle;
    }
    table.dataTable tbody tr:last-child td {
        border-bottom: none !important;
    }
    table.dataTable tbody tr:hover td {
        background-color: #f8faff !important;
    }
    table.dataTable.no-footer {
        border-bottom: none !important;
    }

    /* ── Pagination ── */
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 4px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        padding: 6px 10px !important;
        margin: 0 2px !important;
        border-radius: 8px !important;
        font-size: 0.8rem !important;
        border: 1px solid #e5e7eb !important;
        background: #fff !important;
        color: #374151 !important;
        cursor: pointer;
        transition: all 0.15s;
        line-height: 1.25;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
        background: #eff6ff !important;
        border-color: #bfdbfe !important;
        color: #2563eb !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #fff !important;
        font-weight: 600 !important;
        box-shadow: 0 2px 6px rgba(37,99,235,.25) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        opacity: 0.35 !important;
        cursor: default !important;
        background: #fff !important;
        border-color: #e5e7eb !important;
        color: #9ca3af !important;
    }

    /* ── Info ── */
    .dataTables_wrapper .dataTables_info {
        font-size: 0.78rem;
        color: #9ca3af;
        padding-top: 10px;
    }

    /* ── Empty state ── */
    .dataTables_empty {
        padding: 0 !important;
        background: none !important;
    }

    /* ── Responsive hiding ── */
    @media (max-width: 640px) {
        .dt-col-hide-sm { display: none !important; }
        .dataTables_wrapper .dataTables_filter input { width: 160px; }
        .dataTables_wrapper .dataTables_filter input:focus { width: 180px; }
    }
    @media (max-width: 768px) {
        .dt-col-hide-md { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Daftar Aspirasi Prasarana</h1>
            <p class="text-gray-500 text-sm mt-1">
                @if(Auth::user()->isAdmin())
                    Kelola semua aspirasi dari siswa
                @else
                    Lihat dan kelola aspirasi Anda
                @endif
            </p>
        </div>
        @if(Auth::user()->isSiswa())
            <a href="{{ route('aspirations.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm hover:shadow-md transition text-sm self-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Aspirasi
            </a>
        @endif
    </div>

    <!-- Filter & Search Form -->
    <form method="GET" action="{{ route('aspirations.index') }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4 items-end mb-6">
        <div class="flex-1 w-full">
            <label for="search" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Cari Aspirasi</label>
            <div class="relative">
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari judul, lokasi, atau nama siswa..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="w-full md:w-48">
            <label for="category_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kategori</label>
            <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                @endforeach
            </select>
        </div>
        @if(Auth::user()->isAdmin())
        <div class="w-full md:w-48">
            <label for="status" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                <option value="">Semua Status</option>
                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
            </select>
        </div>
        @endif
        <div class="flex gap-2 w-full md:w-auto">
            <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold text-sm transition shadow-sm">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'category_id', 'status']))
                <a href="{{ route('aspirations.index') }}" class="flex-1 md:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg font-semibold text-sm transition text-center">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($aspirations->count() > 0)
            <div class="p-4 sm:p-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-100">
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul & Kategori</th>
                            @if(Auth::user()->isAdmin())
                                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-md">Pelapor</th>
                            @endif
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-sm">Lokasi</th>
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-sm">Tanggal</th>
                            <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($aspirations as $aspiration)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-3 py-3.5">
                                    <div class="font-medium text-gray-800">{{ $aspiration->judul }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $aspiration->category->nama ?? '-' }}</div>
                                </td>
                                @if(Auth::user()->isAdmin())
                                    <td class="px-3 py-3.5 dt-col-hide-md">
                                        <div class="text-gray-800">{{ $aspiration->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $aspiration->user->nis ?? '-' }}</div>
                                    </td>
                                @endif
                                <td class="px-3 py-3.5 text-gray-600 dt-col-hide-sm">{{ $aspiration->lokasi }}</td>
                                <td class="px-3 py-3.5">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $aspiration->status_color }}">
                                        {{ $aspiration->status_label }}
                                    </span>
                                </td>
                                <td class="px-3 py-3.5 text-gray-500 dt-col-hide-sm">
                                    {{ $aspiration->created_at->format('d M Y') }}
                                </td>
                                <td class="px-3 py-3.5 text-center">
                                    <a href="{{ route('aspirations.show', $aspiration) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-medium text-xs transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $aspirations->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-16 px-4">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-4 text-gray-500 text-lg font-medium">Belum ada aspirasi</p>
                <p class="text-gray-400 text-sm mt-1">Data aspirasi tidak ditemukan atau belum dibuat</p>
                @if(Auth::user()->isSiswa() && !request()->anyFilled(['search', 'category_id', 'status']))
                    <a href="{{ route('aspirations.create') }}" class="mt-6 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Aspirasi Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

