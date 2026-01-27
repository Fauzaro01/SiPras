@extends('layouts.dashboard')

@section('title', 'Daftar Aspirasi - SiPras')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Aspirasi Prasarana</h1>
            <p class="text-gray-600 mt-1">
                @if(Auth::user()->isAdmin())
                    Kelola semua aspirasi dari siswa
                @else
                    Lihat dan kelola aspirasi Anda
                @endif
            </p>
        </div>
        @if(Auth::user()->isSiswa())
            <a href="{{ route('aspirations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition">
                + Buat Aspirasi Baru
            </a>
        @endif
    </div>

    <!-- Aspirations List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($aspirations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul & Kategori</th>
                            @if(Auth::user()->isAdmin())
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($aspirations as $aspiration)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $aspiration->judul }}</div>
                                    <div class="text-sm text-gray-500">{{ $aspiration->kategori }}</div>
                                </td>
                                @if(Auth::user()->isAdmin())
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $aspiration->user->name }}</div>
                                        <div class="text-sm text-gray-500">NIS: {{ $aspiration->user->nis }}</div>
                                    </td>
                                @endif
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $aspiration->lokasi }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $aspiration->status_color }}">
                                        {{ ucfirst($aspiration->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $aspiration->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <a href="{{ route('aspirations.show', $aspiration) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4">
                {{ $aspirations->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-4 text-gray-500 text-lg">Belum ada aspirasi</p>
                @if(Auth::user()->isSiswa())
                    <a href="{{ route('aspirations.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Buat Aspirasi Pertama Anda
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
