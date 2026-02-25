@extends('layouts.dashboard')

@section('title', 'Detail Aspirasi - SiPras')
@section('page-title', 'Detail Aspirasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('aspirations.index') }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Aspirasi
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-5 sm:p-6 text-white">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                <div class="flex-1">
                    <h1 class="text-xl sm:text-2xl font-bold">{{ $aspiration->judul }}</h1>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs sm:text-sm">{{ $aspiration->category->nama ?? '-' }}</span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs sm:text-sm">📍 {{ $aspiration->lokasi }}</span>
                    </div>
                </div>
                <span class="px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold {{ $aspiration->status_color }} self-start flex-shrink-0">
                    {{ ucfirst($aspiration->status) }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-5 sm:p-6 space-y-6">
            <!-- Bukti Foto -->
            @if($aspiration->bukti_foto)
                <div class="flex items-center justify-between bg-blue-50 border border-blue-100 rounded-lg px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Bukti Foto Tersedia</p>
                            <p class="text-xs text-blue-500">Klik tombol untuk melihat foto bukti aspirasi</p>
                        </div>
                    </div>
                    <button
                        onclick="openLightbox('{{ asset('storage/' . $aspiration->bukti_foto) }}')"
                        class="flex-shrink-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition shadow-sm"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat Foto
                    </button>
                </div>
            @endif

            <!-- Informasi Pelapor (untuk admin) -->
            @if(Auth::user()->isAdmin())
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-800 mb-3 text-sm">Informasi Pelapor</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs">Nama</p>
                            <p class="font-medium text-gray-900">{{ $aspiration->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">NIS</p>
                            <p class="font-medium text-gray-900">{{ $aspiration->user->nis }}</p>
                        </div>
                        @if($aspiration->user->kelas)
                            <div>
                                <p class="text-gray-500 text-xs">Kelas</p>
                                <p class="font-medium text-gray-900">{{ $aspiration->user->kelas }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-gray-500 text-xs">Tanggal Lapor</p>
                            <p class="font-medium text-gray-900">{{ $aspiration->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Deskripsi -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-2 text-sm">Deskripsi Masalah</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $aspiration->deskripsi }}</p>
                </div>
            </div>

            <!-- Tanggapan Admin -->
            @if($aspiration->tanggapan_admin)
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2 text-sm">Tanggapan Admin</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $aspiration->tanggapan_admin }}</p>
                    </div>
                </div>
            @endif

            <!-- Admin Action Form -->
            @if(Auth::user()->isAdmin())
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-gray-800 mb-4 text-sm">Update Status & Tanggapan</h3>
                    <form method="POST" action="{{ route('aspirations.update-status', $aspiration) }}" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                            <select 
                                name="status" 
                                id="status" 
                                class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition"
                            >
                                <option value="diproses" {{ $aspiration->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $aspiration->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $aspiration->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div>
                            <label for="tanggapan_admin" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggapan</label>
                            <textarea 
                                name="tanggapan_admin" 
                                id="tanggapan_admin" 
                                rows="4"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition"
                                placeholder="Berikan tanggapan kepada siswa..."
                            >{{ $aspiration->tanggapan_admin }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button 
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm hover:shadow-md transition text-sm"
                            >
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Delete Button (for student's own aspiration that is still being processed) -->
            @if(Auth::user()->isSiswa() && $aspiration->user_id === Auth::id() && $aspiration->status === 'diproses')
                <div class="border-t pt-6">
                    <form method="POST" action="{{ route('aspirations.destroy', $aspiration) }}" onsubmit="return confirm('Yakin ingin menghapus aspirasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold transition text-sm"
                        >
                            Hapus Aspirasi
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Timeline -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
        <h3 class="font-semibold text-gray-800 mb-4 text-sm">Timeline</h3>
        <div class="space-y-3">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Aspirasi dibuat</p>
                    <p class="text-xs text-gray-500">{{ $aspiration->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            @if($aspiration->updated_at != $aspiration->created_at)
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Status diupdate ke <span class="capitalize">{{ $aspiration->status }}</span></p>
                        <p class="text-xs text-gray-500">{{ $aspiration->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Lightbox Modal --}}
<div id="lightbox" onclick="closeLightbox()" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div onclick="event.stopPropagation()" class="relative max-w-4xl w-full">
        <button onclick="closeLightbox()" class="absolute -top-10 right-0 text-white/80 hover:text-white transition">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="lightbox-img" src="" alt="Bukti Foto" class="w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
        <p class="text-center text-xs text-white/60 mt-3">Klik di luar gambar untuk menutup</p>
    </div>
</div>

@push('scripts')
<script>
    function openLightbox(src) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox').classList.remove('hidden');
        document.getElementById('lightbox').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.getElementById('lightbox').classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
@endpush
@endsection
