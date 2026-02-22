@extends('layouts.dashboard')

@section('title', 'Daftar Aspirasi - SiPras')
@section('page-title', 'Aspirasi')

@push('styles')
<style>
    .dataTables_wrapper .dataTables_length select {
        padding: 0.4rem 2rem 0.4rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        background-color: white;
    }
    .dataTables_wrapper .dataTables_filter input {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.4rem 0.85rem;
        margin: 0 0.15rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        border: 1px solid #e5e7eb !important;
        background: white !important;
        color: #374151 !important;
        cursor: pointer;
        transition: all 0.15s;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #eff6ff !important;
        border-color: #bfdbfe !important;
        color: #2563eb !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.4;
        cursor: default;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 0.8rem;
        color: #6b7280;
        padding-top: 0.75rem;
    }
    table.dataTable thead th {
        border-bottom: 2px solid #e5e7eb !important;
    }
    table.dataTable tbody td {
        border-bottom: 1px solid #f3f4f6 !important;
    }
    table.dataTable tbody tr:hover {
        background-color: #f9fafb !important;
    }
    table.dataTable.no-footer {
        border-bottom: none !important;
    }
    @media (max-width: 640px) {
        .dt-col-hide-sm { display: none; }
    }
    @media (max-width: 768px) {
        .dt-col-hide-md { display: none; }
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

    <!-- DataTable Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($aspirations->count() > 0)
            <div class="p-4 sm:p-6">
                <table id="aspirationsTable" class="w-full text-sm">
                    <thead>
                        <tr>
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
                    <tbody>
                        @foreach($aspirations as $aspiration)
                            <tr>
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
                                        {{ ucfirst($aspiration->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-3.5 text-gray-500 dt-col-hide-sm" data-order="{{ $aspiration->created_at->format('Y-m-d') }}">
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
            </div>
        @else
            <div class="text-center py-16 px-4">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-4 text-gray-500 text-lg font-medium">Belum ada aspirasi</p>
                <p class="text-gray-400 text-sm mt-1">Data aspirasi akan muncul di sini</p>
                @if(Auth::user()->isSiswa())
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        if ($('#aspirationsTable').length) {
            $('#aspirationsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [[{{ Auth::user()->isAdmin() ? '4' : '3' }}, 'desc']],
                language: {
                    search: "",
                    searchPlaceholder: "Cari aspirasi...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(disaring dari _MAX_ data)",
                    paginate: {
                        first: "«",
                        last: "»",
                        next: "›",
                        previous: "‹"
                    },
                    zeroRecords: "Tidak ada data yang cocok",
                },
                dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4"lf>rtip',
            });
        }
    });
</script>
@endpush
