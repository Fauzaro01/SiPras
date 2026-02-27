@extends('layouts.dashboard')

@section('title', 'Histori Aspirasi - SiPras')
@section('page-title', 'Histori Aspirasi')

@push('styles')
<style>
    .dataTables_wrapper .dataTables_length label { display:flex;align-items:center;gap:8px;font-size:.85rem;color:#6b7280; }
    .dataTables_wrapper .dataTables_length select { padding:8px 32px 8px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:.85rem;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right 8px center/14px;appearance:none;transition:border-color .2s,box-shadow .2s; }
    .dataTables_wrapper .dataTables_length select:focus { outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12); }
    .dt-search-wrap { position:relative;display:inline-flex;align-items:center; }
    .dt-search-icon { position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#9ca3af;pointer-events:none;width:16px;height:16px; }
    .dataTables_wrapper .dataTables_filter label { font-size:0; }
    .dataTables_wrapper .dataTables_filter input { padding:9px 14px 9px 36px!important;border:1px solid #e5e7eb;border-radius:10px;font-size:.85rem!important;outline:none;transition:border-color .2s,box-shadow .2s,width .25s;width:220px;background:#f9fafb;color:#374151; }
    .dataTables_wrapper .dataTables_filter input:focus { border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12);background:#fff;width:260px; }
    .dataTables_wrapper .dataTables_filter input::placeholder { color:#9ca3af; }
    table.dataTable thead th { border-bottom:2px solid #e5e7eb!important;padding:12px!important;font-size:.7rem;font-weight:600;letter-spacing:.05em;color:#6b7280;text-transform:uppercase;white-space:nowrap; }
    table.dataTable tbody td { border-bottom:1px solid #f3f4f6!important;padding:13px 12px!important;vertical-align:middle; }
    table.dataTable tbody tr:last-child td { border-bottom:none!important; }
    table.dataTable tbody tr:hover td { background:#f8faff!important; }
    table.dataTable.no-footer { border-bottom:none!important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { display:inline-flex;align-items:center;justify-content:center;min-width:34px;padding:6px 10px!important;margin:0 2px!important;border-radius:8px!important;font-size:.8rem!important;border:1px solid #e5e7eb!important;background:#fff!important;color:#374151!important;cursor:pointer;transition:all .15s; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) { background:#eff6ff!important;border-color:#bfdbfe!important;color:#2563eb!important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background:#2563eb!important;border-color:#2563eb!important;color:#fff!important;font-weight:600!important;box-shadow:0 2px 6px rgba(37,99,235,.25)!important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover { opacity:.35!important;cursor:default!important;background:#fff!important;border-color:#e5e7eb!important;color:#9ca3af!important; }
    .dataTables_wrapper .dataTables_info { font-size:.78rem;color:#9ca3af;padding-top:10px; }
    .dataTables_empty { padding:0!important;background:none!important; }
    @media(max-width:640px){ .dt-col-hide-sm{ display:none!important; } .dataTables_wrapper .dataTables_filter input{ width:160px; } }
    @media(max-width:768px){ .dt-col-hide-md{ display:none!important; } }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Histori Aspirasi</h1>
            <p class="text-gray-500 text-sm mt-1">
                @if(Auth::user()->isAdmin())
                    Semua aspirasi yang telah selesai diproses atau ditolak
                @else
                    Aspirasi Anda yang telah selesai diproses atau ditolak
                @endif
            </p>
        </div>
        <a href="{{ route('aspirations.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Aspirasi Aktif
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $aspirations->where('status', 'selesai')->count() }}</p>
                <p class="text-xs text-gray-500">Selesai</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $aspirations->where('status', 'ditolak')->count() }}</p>
                <p class="text-xs text-gray-500">Ditolak</p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($aspirations->count() > 0)
            <div class="p-4 sm:p-6">
                <table id="historiTable" class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul & Kategori</th>
                            @if(Auth::user()->isAdmin())
                                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-md">Pelapor</th>
                            @endif
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-sm">Lokasi</th>
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-md">Feedback</th>
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
                                        {{ $aspiration->status_label }}
                                    </span>
                                </td>
                                <td class="px-3 py-3.5 dt-col-hide-md">
                                    @php $feedbackCount = $aspiration->feedbacks->count(); @endphp
                                    @if($feedbackCount > 0)
                                        <span class="inline-flex items-center gap-1 text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full text-xs font-semibold">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" clip-rule="evenodd"/></svg>
                                            {{ $feedbackCount }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3.5 text-gray-500 dt-col-hide-sm" data-order="{{ $aspiration->updated_at->format('Y-m-d') }}">
                                    {{ $aspiration->updated_at->format('d M Y') }}
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
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-600 font-semibold">Belum ada histori aspirasi</p>
                <p class="text-gray-400 text-sm mt-1">Aspirasi yang sudah selesai atau ditolak akan muncul di sini</p>
                <a href="{{ route('aspirations.index') }}" class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    @if(Auth::user()->isAdmin()) Lihat Daftar Aspirasi @else Lihat Aspirasi Aktif @endif
                </a>
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
        if ($('#historiTable').length) {
            $('#historiTable').DataTable({
                pageLength: 10,
                order: [[{{ Auth::user()->isAdmin() ? '5' : '4' }}, 'desc']],
                language: {
                    search: '',
                    lengthMenu: '_MENU_ per halaman',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(disaring dari _MAX_ data)',
                    paginate: { first: '«', last: '»', next: '›', previous: '‹' },
                    zeroRecords: `<div style="display:flex;flex-direction:column;align-items:center;padding:3rem 1.5rem;"><div style="width:60px;height:60px;border-radius:9999px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;"><svg style="width:28px;height:28px;" fill="none" stroke="#60a5fa" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div><p style="font-weight:600;color:#1f2937;margin:0;">Tidak ada hasil ditemukan</p><p style="color:#9ca3af;font-size:.8125rem;margin:.25rem 0 0;">Coba kata kunci yang berbeda</p></div>`,
                },
                dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5"lf>rtip',
                initComplete: function() {
                    const $input = $('.dataTables_filter input');
                    $input.wrap('<div class="dt-search-wrap"></div>');
                    $input.before(`<svg class="dt-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>`);
                    $input.attr('placeholder', 'Cari histori...');
                }
            });
        }
    });
</script>
@endpush
