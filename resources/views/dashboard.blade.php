@extends('layouts.dashboard')

@section('title', 'Dashboard - SiPras')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ── Welcome Header ─────────────────────────────────────────────── --}}
    <div class="bg-blue-600 rounded-xl shadow-sm p-5 sm:p-6 text-white">
        <h1 class="text-2xl sm:text-3xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-blue-100 text-sm sm:text-base">
            @if(Auth::user()->isAdmin())
                Anda login sebagai Admin — kelola semua aspirasi prasarana sekolah.
            @else
                NIS: {{ Auth::user()->nis }} &nbsp;·&nbsp; Kelas: {{ Auth::user()->kelas ?? '-' }}
            @endif
        </p>
    </div>
    <!-- Export Buttons -->
    <div class="flex space-x-3 mt-4">
        <a href="{{ route('aspirations.export') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Export CSV</a>
        <a href="{{ route('aspirations.export.pdf') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Export PDF</a>
    </div>

    {{-- ── Statistics Cards ────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Total Aspirasi</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_aspirasi'] }}</p>
                </div>
                <div class="bg-blue-50 p-2.5 rounded-xl">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Diajukan</p>
                    <p class="text-2xl sm:text-3xl font-bold text-yellow-500 mt-1">{{ $stats['diajukan'] }}</p>
                </div>
                <div class="bg-yellow-50 p-2.5 rounded-xl">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Selesai</p>
                    <p class="text-2xl sm:text-3xl font-bold text-green-600 mt-1">{{ $stats['selesai'] }}</p>
                </div>
                <div class="bg-green-50 p-2.5 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Ditolak</p>
                    <p class="text-2xl sm:text-3xl font-bold text-red-600 mt-1">{{ $stats['ditolak'] }}</p>
                </div>
                <div class="bg-red-50 p-2.5 rounded-xl">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Charts Row ───────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Bar chart: tren bulanan (2 cols) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-bold text-gray-800 text-sm sm:text-base">Tren Aspirasi</h2>
                    <p class="text-xs text-gray-400 mt-0.5">6 bulan terakhir</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="relative h-52">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        {{-- Doughnut chart: distribusi status --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-bold text-gray-800 text-sm sm:text-base">Distribusi Status</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Semua aspirasi</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
            </div>
            <div class="relative h-40 flex items-center justify-center">
                <canvas id="doughnutChart"></canvas>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-1.5 text-xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 flex-shrink-0"></span>
                    <span class="text-gray-500">Diajukan ({{ $stats['diajukan'] }})</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 flex-shrink-0"></span>
                    <span class="text-gray-500">Diproses ({{ $stats['diproses'] }})</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500 flex-shrink-0"></span>
                    <span class="text-gray-500">Selesai ({{ $stats['selesai'] }})</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 flex-shrink-0"></span>
                    <span class="text-gray-500">Ditolak ({{ $stats['ditolak'] }})</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Recent Aspirations ───────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 sm:p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base sm:text-lg font-bold text-gray-800">Aspirasi Terbaru</h2>
            <a href="{{ route('aspirations.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium transition">
                Lihat Semua →
            </a>
        </div>
        <div class="p-4 sm:p-6">
            @if($recent_aspirations->count() > 0)
                <div class="space-y-3">
                    @foreach($recent_aspirations as $aspiration)
                        <a href="{{ route('aspirations.show', $aspiration) }}"
                           class="block border border-gray-100 rounded-lg p-4 hover:shadow-md hover:border-blue-100 transition">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-800 truncate text-sm">{{ $aspiration->judul }}</h3>
                                    @if(Auth::user()->isAdmin())
                                        <p class="text-xs text-gray-500 mt-1">
                                            Oleh: {{ $aspiration->user->name }} ({{ $aspiration->user->nis }})
                                        </p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $aspiration->category->nama ?? '-' }} &nbsp;·&nbsp; {{ $aspiration->lokasi }}
                                        &nbsp;·&nbsp; {{ $aspiration->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $aspiration->status_color }} self-start flex-shrink-0">
                                    {{ $aspiration->status_label }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 text-gray-400">
                    <svg class="mx-auto h-12 w-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-2 text-sm">Belum ada aspirasi</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const barLabels = @json($chartMonths);
    const barData   = @json($chartCounts);

    // Bar Chart — Tren Bulanan
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Aspirasi',
                data: barData,
                backgroundColor: 'rgba(59, 130, 246, 0.15)',
                borderColor: 'rgba(59, 130, 246, 0.8)',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} aspirasi` } },
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#9ca3af' } },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { size: 11 }, color: '#9ca3af' },
                    grid: { color: 'rgba(243,244,246,1)' },
                },
            },
        },
    });

    // Doughnut Chart — Distribusi Status
    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Diajukan', 'Diproses', 'Selesai', 'Ditolak'],
            datasets: [{
                data: [{{ $stats['diajukan'] }}, {{ $stats['diproses'] }}, {{ $stats['selesai'] }}, {{ $stats['ditolak'] }}],
                backgroundColor: [
                    'rgba(234,179,8,0.85)',
                    'rgba(59,130,246,0.85)',
                    'rgba(34,197,94,0.85)',
                    'rgba(239,68,68,0.85)',
                ],
                borderWidth: 2,
                borderColor: '#ffffff',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } },
            },
        },
    });
</script>
@endpush
