@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna - SiPras')
@section('page-title', 'Manajemen Pengguna')

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
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background:linear-gradient(135deg,#3b82f6,#2563eb)!important;border-color:#2563eb!important;color:#fff!important;font-weight:600!important;box-shadow:0 2px 6px rgba(37,99,235,.3)!important; }
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
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola akun siswa yang terdaftar di SiPras</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                <p class="text-xs text-gray-500">Total Pengguna</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'siswa')->count() }}</p>
                <p class="text-xs text-gray-500">Siswa</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 col-span-2 sm:col-span-1">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</p>
                <p class="text-xs text-gray-500">Admin</p>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6">
            <table id="usersTable" class="w-full text-sm">
                <thead>
                    <tr>
                        <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-sm">NIS / Kelas</th>
                        <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-md">Email</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-sm">Aspirasi</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="px-3 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br {{ $user->isAdmin() ? 'from-purple-500 to-indigo-500' : 'from-blue-500 to-cyan-500' }} flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400">Bergabung {{ $user->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-3.5 dt-col-hide-sm">
                                @if($user->isSiswa())
                                    <p class="text-gray-800 font-medium">{{ $user->nis ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->kelas ?? '-' }}</p>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-3 py-3.5 text-gray-600 dt-col-hide-md">{{ $user->email }}</td>
                            <td class="px-3 py-3.5 text-center dt-col-hide-sm">
                                <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">{{ $user->aspirations_count }}</span>
                            </td>
                            <td class="px-3 py-3.5 text-center">
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-sky-100 text-sky-700' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-3 py-3.5 text-center">
                                <div class="flex justify-center gap-2">
                                    <button
                                        onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->nis }}', '{{ $user->kelas }}')"
                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-xs font-medium transition px-2 py-1 rounded hover:bg-blue-50"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    @if($user->id !== Auth::id())
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus pengguna \'{{ $user->name }}\'? Semua aspirasi miliknya juga akan dihapus!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 text-red-500 hover:text-red-700 text-xs font-medium transition px-2 py-1 rounded hover:bg-red-50">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-300 px-2 py-1">Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-800">Edit Pengguna</h3>
            <button onclick="closeEditModal()" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit-name" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition" required>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="edit-email" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">NIS</label>
                    <input type="text" name="nis" id="edit-nis" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Kelas</label>
                    <input type="text" name="kelas" id="edit-kelas" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition">
                </div>
            </div>
            <div class="border-t border-gray-100 pt-4">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Password Baru <span class="text-gray-400">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" id="edit-password" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition" placeholder="Min. 6 karakter">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm transition">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-semibold text-sm shadow-sm transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            pageLength: 10,
            order: [[0, 'asc']],
            language: {
                search: '',
                lengthMenu: '_MENU_ per halaman',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ pengguna',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ data)',
                paginate: { first: '«', last: '»', next: '›', previous: '‹' },
                zeroRecords: `<div style="display:flex;flex-direction:column;align-items:center;padding:3rem 1.5rem;"><div style="width:60px;height:60px;border-radius:9999px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;"><svg style="width:28px;height:28px;" fill="none" stroke="#60a5fa" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div><p style="font-weight:600;color:#1f2937;margin:0;">Pengguna tidak ditemukan</p><p style="color:#9ca3af;font-size:.8125rem;margin:.25rem 0 0;">Coba kata kunci lain</p></div>`,
                emptyTable: '<div style="display:flex;flex-direction:column;align-items:center;padding:3rem 1.5rem;"><p style="color:#9ca3af;font-size:.875rem;">Belum ada pengguna terdaftar</p></div>',
            },
            dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5"lf>rtip',
            initComplete: function() {
                const $input = $('.dataTables_filter input');
                $input.wrap('<div class="dt-search-wrap"></div>');
                $input.before(`<svg class="dt-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>`);
                $input.attr('placeholder', 'Cari pengguna...');
            }
        });
    });

    function openEditModal(id, name, email, nis, kelas) {
        document.getElementById('editForm').action = '/users/' + id;
        document.getElementById('edit-name').value  = name;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-nis').value   = nis || '';
        document.getElementById('edit-kelas').value = kelas || '';
        document.getElementById('edit-password').value = '';
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeEditModal(); });
</script>
@endpush
