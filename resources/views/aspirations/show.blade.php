@extends('layouts.dashboard')

@section('title', 'Detail Aspirasi - SiPras')
@section('page-title', 'Detail Aspirasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Back Button --}}
    <div>
        <a href="{{ route('aspirations.index') }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Aspirasi
        </a>
    </div>

    {{-- ═══ Main Card ═══ --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header --}}
        <div class="bg-blue-600 p-5 sm:p-6 text-white">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                <div class="flex-1">
                    <h1 class="text-xl sm:text-2xl font-bold">{{ $aspiration->judul }}</h1>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs sm:text-sm">{{ $aspiration->category->nama ?? '-' }}</span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs sm:text-sm">📍 {{ $aspiration->lokasi }}</span>
                    </div>
                </div>
                <div class="flex flex-col sm:items-end gap-2 self-start flex-shrink-0">
                    <span class="px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold {{ $aspiration->status_color }}">
                        {{ $aspiration->status_label }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-white border border-white/20">
                        {{ $aspiration->priority_label }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-5 sm:p-6 space-y-6">

            {{-- Bukti Foto --}}
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
                    <button onclick="openLightbox('{{ asset('storage/' . $aspiration->bukti_foto) }}')"
                        class="flex-shrink-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat Foto
                    </button>
                </div>
            @endif

            {{-- Informasi Pelapor (admin only) --}}
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

            {{-- Deskripsi --}}
            <div>
                <h3 class="font-semibold text-gray-800 mb-2 text-sm">Deskripsi Masalah</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $aspiration->deskripsi }}</p>
                </div>
            </div>

            {{-- Admin: Update Status Form --}}
            @if(Auth::user()->isAdmin())
                <div class="border-t pt-5">
                    <h3 class="font-semibold text-gray-800 mb-3 text-sm">Update Status Aspirasi</h3>
                    <form method="POST" action="{{ route('aspirations.update-status', $aspiration) }}" class="flex flex-col sm:flex-row items-end gap-3">
                        @csrf
                        <div class="w-full sm:w-64">
                            <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm transition bg-white">
                                <option value="diajukan" {{ $aspiration->status == 'diajukan' ? 'selected' : '' }}>🟡 Diajukan</option>
                                <option value="diproses" {{ $aspiration->status == 'diproses' ? 'selected' : '' }}>🔵 Diproses</option>
                                <option value="selesai"  {{ $aspiration->status == 'selesai'  ? 'selected' : '' }}>🟢 Selesai</option>
                                <option value="ditolak"  {{ $aspiration->status == 'ditolak'  ? 'selected' : '' }}>🔴 Ditolak</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="flex-shrink-0 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm hover:shadow-md transition text-sm">
                            Simpan Status
                        </button>
                    </form>
                </div>
            @endif

            {{-- Tombol Hapus (siswa sendiri, status diajukan) --}}
            @if(Auth::user()->isSiswa() && $aspiration->user_id === Auth::id() && $aspiration->status === 'diajukan')
                <div class="border-t pt-5">
                    <form method="POST" action="{{ route('aspirations.destroy', $aspiration) }}"
                        data-confirm="Yakin ingin menghapus aspirasi ini?">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold transition text-sm">
                            Hapus Aspirasi
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>

    {{-- ═══ Feedback Timeline ═══ --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 text-sm">Feedback & Timeline</h3>
            @if($aspiration->feedbacks->count() > 0)
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $aspiration->feedbacks->count() }}
                </span>
            @endif
        </div>

        <div class="p-5 sm:p-6">
            {{-- Timeline list --}}
            <div class="relative">
                {{-- Garis vertikal --}}
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-100"></div>

                <div class="space-y-0">

                    {{-- Item: Aspirasi diajukan --}}
                    <div class="relative flex items-start pb-6">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-yellow-100 border-2 border-white shadow-sm flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800">Aspirasi diajukan</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $aspiration->created_at->translatedFormat('d F Y, H:i') }}</p>
                            <p class="text-xs text-gray-500 mt-1">oleh <span class="font-medium">{{ $aspiration->user->name ?? 'Siswa' }}</span></p>
                        </div>
                    </div>

                    {{-- Items: Setiap feedback (F-13) --}}
                    @foreach($aspiration->feedbacks as $feedback)
                        <div class="relative flex items-start pb-6" id="feedback-{{ $feedback->id }}">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center z-10">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-400">
                                            <span class="font-semibold text-gray-700">{{ $feedback->user->name ?? 'Admin' }}</span>
                                            &middot; {{ $feedback->created_at->translatedFormat('d F Y, H:i') }}
                                        </p>
                                        <div class="mt-2 bg-blue-50 border border-blue-100 rounded-lg px-4 py-3">
                                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $feedback->pesan }}</p>
                                        </div>

                                        {{-- F-13: Replies/Thread --}}
                                        @if($feedback->replies && $feedback->replies->count() > 0)
                                            <div class="mt-4 pl-4 border-l-2 border-gray-100 dark:border-gray-800 space-y-4">
                                                @foreach($feedback->replies as $reply)
                                                    <div class="flex items-start gap-3" id="feedback-{{ $reply->id }}">
                                                        <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center flex-shrink-0 text-[10px] font-bold">
                                                            {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div class="flex items-start justify-between gap-2">
                                                                <div>
                                                                    <span class="text-xs font-semibold text-gray-700">{{ $reply->user->name ?? 'Pengguna' }}</span>
                                                                    <span class="text-[10px] text-gray-400">&middot; {{ $reply->created_at->translatedFormat('d F Y, H:i') }}</span>
                                                                </div>
                                                                @if(Auth::user()->isAdmin())
                                                                    <form method="POST"
                                                                        action="{{ route('feedbacks.destroy', [$aspiration, $reply]) }}"
                                                                        data-confirm="Hapus balasan ini?"
                                                                        class="flex-shrink-0">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" title="Hapus balasan"
                                                                            class="text-gray-300 hover:text-red-500 transition rounded-md hover:bg-red-50 p-0.5">
                                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                            </svg>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                            <p class="text-xs text-gray-700 mt-1 bg-gray-50 border border-gray-100 rounded-lg px-3 py-2 leading-relaxed whitespace-pre-line">{{ $reply->pesan }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Reply Form Button/Toggle --}}
                                        <div class="mt-2">
                                            <button onclick="toggleReplyForm({{ $feedback->id }})" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition">
                                                Balas...
                                            </button>
                                        </div>

                                        {{-- Inline Reply Form --}}
                                        <div id="reply-form-{{ $feedback->id }}" class="hidden mt-3 max-w-lg">
                                            <form method="POST" action="{{ route('feedbacks.store', $aspiration) }}" class="flex gap-2 items-end">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $feedback->id }}">
                                                <div class="flex-1">
                                                    <textarea name="pesan" rows="1" required
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-1 focus:ring-blue-500 focus:outline-none resize-none bg-gray-50 focus:bg-white"
                                                        placeholder="Tulis balasan..."></textarea>
                                                </div>
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-3 py-2 rounded-lg shadow-sm transition">
                                                    Kirim
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                    @if(Auth::user()->isAdmin())
                                        <form method="POST"
                                            action="{{ route('feedbacks.destroy', [$aspiration, $feedback]) }}"
                                            data-confirm="Hapus feedback ini beserta semua balasannya?"
                                            class="flex-shrink-0 mt-0.5">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus feedback"
                                                class="p-1.5 text-gray-300 hover:text-red-500 transition rounded-md hover:bg-red-50">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Item terakhir: status saat ini (jika bukan diajukan) --}}
                    @if($aspiration->status !== 'diajukan')
                        @php
                            $dotBg = match($aspiration->status) {
                                'diproses' => 'bg-blue-500',
                                'selesai'  => 'bg-green-500',
                                'ditolak'  => 'bg-red-500',
                                default    => 'bg-gray-400',
                            };
                        @endphp
                        <div class="relative flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $dotBg }} border-2 border-white shadow-sm flex items-center justify-center z-10">
                                @if($aspiration->status === 'selesai')
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @elseif($aspiration->status === 'ditolak')
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-semibold text-gray-800">
                                    Status diubah ke
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $aspiration->status_color }}">
                                        {{ $aspiration->status_label }}
                                    </span>
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $aspiration->updated_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Empty feedback state --}}
            @if($aspiration->feedbacks->count() === 0)
                <div class="mt-2 text-center py-4">
                    <p class="text-gray-400 text-sm">Belum ada feedback dari admin</p>
                </div>
            @endif

            {{-- Form Tambah Feedback (admin only) --}}
            @if(Auth::user()->isAdmin())
                <div class="mt-5 pt-5 border-t border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Tambah Feedback</h4>

                    <form method="POST" action="{{ route('feedbacks.store', $aspiration) }}" class="space-y-3">
                        @csrf
                        <textarea
                            name="pesan"
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm transition resize-none bg-gray-50 focus:bg-white"
                            placeholder="Tulis feedback untuk aspirasi ini..."
                        >{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm hover:shadow-md transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Kirim Feedback
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    {{-- ═══ Comments Section (F-10) ═══ --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 text-sm">Diskusi & Komentar</h3>
            @if($aspiration->comments->count() > 0)
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $aspiration->comments->count() }}
                </span>
            @endif
        </div>

        <div class="p-5 sm:p-6 space-y-6">
            {{-- Comment List --}}
            @if($aspiration->comments->count() > 0)
                <div class="space-y-4">
                    @foreach($aspiration->comments as $comment)
                        <div class="flex items-start gap-3 pb-4 border-b border-gray-50 last:border-0 last:pb-0" id="comment-{{ $comment->id }}">
                            {{-- User Avatar / Initial --}}
                            @if($comment->user->avatar)
                                <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="{{ $comment->user->name }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <div>
                                        <span class="text-sm font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                        @if($comment->user->isAdmin())
                                            <span class="ml-1 bg-blue-100 text-blue-800 text-[10px] font-bold px-1.5 py-0.5 rounded">Admin</span>
                                        @else
                                            <span class="ml-1 bg-gray-100 text-gray-600 text-[10px] font-medium px-1.5 py-0.5 rounded">{{ $comment->user->kelas ?? 'Siswa' }}</span>
                                        @endif
                                        <span class="text-xs text-gray-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>

                                    {{-- Delete Button --}}
                                    @can('delete', $comment)
                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}" data-confirm="Hapus komentar ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-300 hover:text-red-500 transition p-1 rounded-md hover:bg-red-50" title="Hapus komentar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <p class="text-sm text-gray-650 mt-1 leading-relaxed whitespace-pre-line">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-400 text-sm">Belum ada diskusi. Jadilah yang pertama berkomentar!</p>
                </div>
            @endif

            {{-- Post Comment Form --}}
            <div class="pt-4 border-t border-gray-100">
                <form method="POST" action="{{ route('comments.store', $aspiration) }}" class="space-y-3">
                    @csrf
                    <div>
                        <label for="comment-content" class="sr-only">Tulis komentar</label>
                        <textarea
                            id="comment-content"
                            name="content"
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 text-sm transition resize-none bg-gray-50 focus:bg-white"
                            placeholder="Tulis komentar/masukan untuk aspirasi ini..."
                            required
                        >{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm hover:shadow-md transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>
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

    // F-13: Toggle reply form
    function toggleReplyForm(id) {
        var form = document.getElementById('reply-form-' + id);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            form.querySelector('textarea').focus();
        } else {
            form.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
