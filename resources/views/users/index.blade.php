@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna - SiPras')
@section('page-title', 'Manajemen Pengguna')

@push('styles')
<style>
    /* Custom style tweaks for users list */
    table tbody tr:hover td { background:#f8faff!important; }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola akun pengguna yang terdaftar di SiPras</p>
        </div>
        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm hover:shadow-md transition text-sm self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengguna
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-500">Total Pengguna</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['siswa'] }}</p>
                <p class="text-xs text-gray-500">Siswa</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 col-span-2 sm:col-span-1">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['admin'] }}</p>
                <p class="text-xs text-gray-500">Admin</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Form -->
    <form method="GET" action="{{ route('users.index') }}" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4 items-end mb-6">
        <div class="flex-1 w-full">
            <label for="search" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Cari Pengguna</label>
            <div class="relative">
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, username..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="w-full md:w-48">
            <label for="role" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Role</label>
            <select name="role" id="role" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold text-sm transition shadow-sm">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'role']))
                <a href="{{ route('users.index') }}" class="flex-1 md:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg font-semibold text-sm transition text-center">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($users->count() > 0)
            <div class="p-4 sm:p-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-100">
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                            <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-sm">NIS / Kelas</th>
                            <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dt-col-hide-sm">Aspirasi</th>
                            <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-3 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full {{ $user->isAdmin() ? 'bg-blue-500' : 'bg-sky-400' }} flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
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
                                            onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->nis }}', '{{ $user->kelas }}')"
                                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-xs font-medium transition px-2 py-1 rounded hover:bg-blue-50"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </button>
                                        @if($user->id !== Auth::id())
                                            <form method="POST" action="{{ route('users.destroy', $user) }}" data-confirm="Yakin ingin menghapus pengguna '{{ $user->name }}'? Semua aspirasi miliknya juga akan dihapus!">
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

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-16 px-4">
                <p class="text-gray-500 text-lg font-medium">Pengguna tidak ditemukan</p>
                <p class="text-gray-400 text-sm mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        @endif
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
                <input type="password" name="password" id="edit-password" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition" placeholder="Min. 8 karakter">
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
<script>
    function openEditModal(id, name, nis, kelas) {
        document.getElementById('editForm').action = '/users/' + id;
        document.getElementById('edit-name').value  = name;
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
