@extends('layouts.dashboard')

@section('title', 'Kelola Kategori - SiPras')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 102 0V7zm-1 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Add Category Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Tambah Kategori Baru</h2>
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="nama" 
                        id="nama" 
                        value="{{ old('nama') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition"
                        placeholder="Contoh: Ruang Kelas"
                        required
                    >
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                    <input 
                        type="text" 
                        name="deskripsi" 
                        id="deskripsi" 
                        value="{{ old('deskripsi') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition"
                        placeholder="Deskripsi singkat (opsional)"
                    >
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm hover:shadow-md transition text-sm">
                    Tambah Kategori
                </button>
            </div>
        </form>
    </div>

    {{-- Categories List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Kategori</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola kategori aspirasi yang tersedia untuk siswa</p>
        </div>

        @if($categories->count() > 0)
            {{-- Desktop Table --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Nama</th>
                            <th class="px-6 py-3 text-left font-semibold">Deskripsi</th>
                            <th class="px-6 py-3 text-center font-semibold">Jumlah Aspirasi</th>
                            <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50 transition" id="row-{{ $category->id }}">
                                {{-- Display mode --}}
                                <td class="px-6 py-4 font-medium text-gray-900 display-mode-{{ $category->id }}">{{ $category->nama }}</td>
                                <td class="px-6 py-4 text-gray-600 display-mode-{{ $category->id }}">{{ $category->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4 text-center display-mode-{{ $category->id }}">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-semibold">{{ $category->aspirations_count }}</span>
                                </td>
                                <td class="px-6 py-4 text-center display-mode-{{ $category->id }}">
                                    <div class="flex justify-center gap-2">
                                        <button onclick="toggleEdit({{ $category->id }})" class="text-blue-600 hover:text-blue-800 text-xs font-medium transition">Edit</button>
                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" data-confirm="Yakin ingin menghapus kategori '{{ $category->nama }}'?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium transition">Hapus</button>
                                        </form>
                                    </div>
                                </td>

                                {{-- Edit mode (hidden by default) --}}
                                <td class="px-6 py-4 edit-mode-{{ $category->id }} hidden" colspan="4">
                                    <form method="POST" action="{{ route('categories.update', $category) }}" class="flex flex-wrap items-end gap-3">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex-1 min-w-[150px]">
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Nama</label>
                                            <input type="text" name="nama" value="{{ $category->nama }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" required>
                                        </div>
                                        <div class="flex-1 min-w-[150px]">
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
                                            <input type="text" name="deskripsi" value="{{ $category->deskripsi }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition">Simpan</button>
                                            <button type="button" onclick="toggleEdit({{ $category->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-xs font-semibold transition">Batal</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="sm:hidden divide-y divide-gray-100">
                @foreach($categories as $category)
                    <div class="p-4" id="card-{{ $category->id }}">
                        {{-- Display mode --}}
                        <div class="card-display-{{ $category->id }}">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $category->nama }}</h3>
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $category->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-semibold flex-shrink-0 ml-2">{{ $category->aspirations_count }} aspirasi</span>
                            </div>
                            <div class="flex gap-3 mt-3">
                                <button onclick="toggleEditCard({{ $category->id }})" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Edit</button>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" data-confirm="Yakin ingin menghapus kategori '{{ $category->nama }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>

                        {{-- Edit mode (hidden) --}}
                        <div class="card-edit-{{ $category->id }} hidden">
                            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama</label>
                                    <input type="text" name="nama" value="{{ $category->nama }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
                                    <input type="text" name="deskripsi" value="{{ $category->deskripsi }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition flex-1">Simpan</button>
                                    <button type="button" onclick="toggleEditCard({{ $category->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-xs font-semibold transition flex-1">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <p class="text-sm font-medium">Belum ada kategori</p>
                <p class="text-xs mt-1">Tambahkan kategori pertama menggunakan form di atas</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function toggleEdit(id) {
        document.querySelectorAll('.display-mode-' + id).forEach(el => el.classList.toggle('hidden'));
        document.querySelectorAll('.edit-mode-' + id).forEach(el => el.classList.toggle('hidden'));
    }

    function toggleEditCard(id) {
        document.querySelector('.card-display-' + id).classList.toggle('hidden');
        document.querySelector('.card-edit-' + id).classList.toggle('hidden');
    }
</script>
@endpush
@endsection