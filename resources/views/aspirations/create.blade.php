@extends('layouts.dashboard')

@section('title', 'Buat Aspirasi - SiPras')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Buat Aspirasi Baru</h1>
            <p class="text-gray-600 mt-1">Sampaikan pengaduan prasarana sekolah Anda</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('aspirations.store') }}" class="space-y-6">
            @csrf

            <!-- Judul -->
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Aspirasi <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="judul" 
                    id="judul" 
                    value="{{ old('judul') }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: Kerusakan Meja di Kelas X-1"
                >
                @error('judul')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select 
                    name="kategori" 
                    id="kategori" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Pilih Kategori</option>
                    <option value="Ruang Kelas" {{ old('kategori') == 'Ruang Kelas' ? 'selected' : '' }}>Ruang Kelas</option>
                    <option value="Toilet" {{ old('kategori') == 'Toilet' ? 'selected' : '' }}>Toilet</option>
                    <option value="Laboratorium" {{ old('kategori') == 'Laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                    <option value="Perpustakaan" {{ old('kategori') == 'Perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                    <option value="Kantin" {{ old('kategori') == 'Kantin' ? 'selected' : '' }}>Kantin</option>
                    <option value="Lapangan" {{ old('kategori') == 'Lapangan' ? 'selected' : '' }}>Lapangan</option>
                    <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi -->
            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                    Lokasi <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="lokasi" 
                    id="lokasi" 
                    value="{{ old('lokasi') }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: Gedung A Lantai 2 Kelas X-1"
                >
                @error('lokasi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="deskripsi" 
                    id="deskripsi" 
                    rows="6"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Jelaskan detail masalah prasarana yang Anda temukan..."
                >{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('aspirations.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                    Batal
                </a>
                <button 
                    type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition"
                >
                    Kirim Aspirasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
