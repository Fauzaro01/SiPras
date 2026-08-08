<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPras — Sistem Aspirasi Prasarana Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up            { animation: fadeUp .65s ease both; }
        .fade-up-d1         { animation: fadeUp .65s .1s ease both; }
        .fade-up-d2         { animation: fadeUp .65s .2s ease both; }
        .fade-up-d3         { animation: fadeUp .65s .35s ease both; }

        .gradient-text {
            color: #2563eb;
        }

        /* Subtle grid bg */
        .grid-bg {
            background-color: #f8faff;
            background-image:
                linear-gradient(rgba(99,102,241,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,.06) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Card lift */
        .lift { transition: transform .25s ease, box-shadow .25s ease; }
        .lift:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(37,99,235,.12); }

        /* Step connector */
        .step-connector {
            position: absolute;
            top: 22px;
            left: calc(50% + 26px);
            right: calc(-50% + 26px);
            height: 2px;
            background: #bfdbfe;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased overflow-x-hidden">

    {{-- ═══════════════ NAV ═══════════════ --}}
    <header class="fixed inset-x-0 top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-15 py-3">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="w-4.5 h-4.5 text-white w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-900">SiPras</span>
            </a>

            {{-- Nav links (desktop) --}}
            <nav class="hidden md:flex items-center gap-1">
                <a href="#fitur"     class="text-sm text-gray-500 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-100 transition">Fitur</a>
                <a href="#cara-kerja" class="text-sm text-gray-500 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-100 transition">Cara Kerja</a>
            </nav>

            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
                Masuk
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </header>

    {{-- ═══════════════ HERO ═══════════════ --}}
    <section class="grid-bg pt-28 pb-20 md:pt-36 md:pb-28">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">

            {{-- Badge --}}
            <div class="fade-up inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold px-3.5 py-1.5 rounded-full mb-6">
                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                Platform Aspirasi Sekolah
            </div>

            {{-- Heading --}}
            <h1 class="fade-up-d1 text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight text-gray-900 mb-5">
                Suarakan <span class="gradient-text">Aspirasi</span><br class="hidden sm:block">
                Prasarana Sekolahmu
            </h1>

            {{-- Sub --}}
            <p class="fade-up-d2 text-gray-500 text-lg sm:text-xl max-w-2xl mx-auto mb-9 leading-relaxed">
                Laporkan kerusakan fasilitas sekolah dengan mudah. Admin merespons cepat, statusnya bisa kamu pantau langsung.
            </p>

            {{-- CTA --}}
            <div class="fade-up-d3 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-7 py-3.5 rounded-xl shadow-md hover:shadow-lg transition text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Mulai Sekarang
                </a>
                <a href="#cara-kerja"
                   class="inline-flex items-center gap-2 bg-white text-gray-700 font-semibold px-7 py-3.5 rounded-xl border border-gray-200 hover:border-blue-300 hover:text-blue-600 transition text-base shadow-sm">
                    Lihat Cara Kerja
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>
        </div>

    </section>

    {{-- ═══════════════ STATS ═══════════════ --}}
    <section class="bg-white py-14 border-y border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-4xl font-extrabold gradient-text">{{ $totalAspirations }}</p>
                    <p class="text-sm text-gray-500 mt-1.5 font-medium">Aspirasi Dilaporkan</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold gradient-text">{{ $persenSelesai }}%</p>
                    <p class="text-sm text-gray-500 mt-1.5 font-medium">Terselesaikan</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold gradient-text">{{ $totalSiswa }}</p>
                    <p class="text-sm text-gray-500 mt-1.5 font-medium">Siswa Aktif</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold gradient-text">24/7</p>
                    <p class="text-sm text-gray-500 mt-1.5 font-medium">Akses Kapan Saja</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════ FITUR ═══════════════ --}}
    <section id="fitur" class="py-24 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14">
                <p class="text-blue-600 text-sm font-semibold uppercase tracking-widest">Fitur Utama</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2">Kenapa Pilih SiPras?</h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto">Dirancang untuk mempermudah komunikasi antara siswa dan pengelola sekolah.</p>
            </div>

            <div class="grid sm:grid-cols-3 gap-6">
                {{-- F1 --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm lift">
                    <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1.5">Lapor Mudah & Cepat</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Isi formulir singkat dengan deskripsi, lokasi, dan foto bukti—selesai dalam hitungan detik.</p>
                </div>
                {{-- F2 --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm lift relative">
                    <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-2.5 py-0.5 rounded-full">Populer</span>
                    <div class="w-11 h-11 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1.5">Feedback Timeline</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Admin dapat memberikan beberapa feedback. Siswa bisa melihat setiap update dalam tampilan timeline.</p>
                </div>
                {{-- F3 --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm lift">
                    <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1.5">Pantau Status Real-time</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Lacak setiap laporan mulai dari Diajukan → Diproses → Selesai secara transparan.</p>
                </div>
            </div>

            {{-- Extra features row --}}
            <div class="grid sm:grid-cols-3 gap-4 mt-5">
                <div class="bg-white rounded-xl px-5 py-4 border border-gray-100 flex items-center gap-3 lift">
                    <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Kategorisasi Laporan</p>
                        <p class="text-xs text-gray-400">Terstruktur per jenis prasarana</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl px-5 py-4 border border-gray-100 flex items-center gap-3 lift">
                    <div class="w-9 h-9 bg-pink-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Autentikasi Aman</p>
                        <p class="text-xs text-gray-400">Login via NIS / username</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl px-5 py-4 border border-gray-100 flex items-center gap-3 lift">
                    <div class="w-9 h-9 bg-violet-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Dashboard Informatif</p>
                        <p class="text-xs text-gray-400">Statistik & ringkasan laporan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════ CARA KERJA ═══════════════ --}}
    <section id="cara-kerja" class="py-24 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14">
                <p class="text-blue-600 text-sm font-semibold uppercase tracking-widest">Alur Kerja</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2">Cara Kerja SiPras</h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto">Empat langkah sederhana dari laporan masuk sampai terselesaikan.</p>
            </div>

            <div class="grid sm:grid-cols-4 gap-6 relative">
                @php
                    $steps = [
                        ['num'=>'1','color'=>'blue',   'icon'=>'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1',  'title'=>'Login',        'desc'=>'Masuk pakai NIS (siswa) atau username (admin)'],
                        ['num'=>'2','color'=>'indigo',  'icon'=>'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'title'=>'Buat Laporan', 'desc'=>'Isi form dengan judul, deskripsi, lokasi, dan foto'],
                        ['num'=>'3','color'=>'violet',  'icon'=>'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'title'=>'Admin Tinjau', 'desc'=>'Admin memperbarui status dan memberikan feedback'],
                        ['num'=>'4','color'=>'emerald', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title'=>'Selesai!',      'desc'=>'Masalah terselesaikan dan tercatat secara transparan'],
                    ];
                    $colorMap = [
                        'blue'   => ['bg'=>'bg-blue-600',   'light'=>'bg-blue-100',   'icon'=>'text-blue-600'],
                        'indigo' => ['bg'=>'bg-indigo-600', 'light'=>'bg-indigo-100', 'icon'=>'text-indigo-600'],
                        'violet' => ['bg'=>'bg-violet-600', 'light'=>'bg-violet-100', 'icon'=>'text-violet-600'],
                        'emerald'=> ['bg'=>'bg-emerald-600','light'=>'bg-emerald-100','icon'=>'text-emerald-600'],
                    ];
                @endphp

                @foreach($steps as $i => $step)
                    @php $c = $colorMap[$step['color']]; @endphp
                    <div class="relative text-center">
                        {{-- connector line (not last) --}}
                        @if($i < 3)
                            <div class="step-connector hidden sm:block"></div>
                        @endif

                        <div class="relative inline-flex items-center justify-center mb-4">
                            <div class="w-11 h-11 {{ $c['light'] }} rounded-2xl flex items-center justify-center">
                                <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 {{ $c['bg'] }} text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $step['num'] }}</span>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1.5">{{ $step['title'] }}</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════ CTA ═══════════════ --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
            <div class="bg-blue-600 rounded-3xl p-12 relative overflow-hidden shadow-xl">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="relative">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Siap Menyuarakan Aspirasimu?</h2>
                    <p class="text-blue-100 text-base mb-8 max-w-md mx-auto">Bergabunglah dan bantu ciptakan lingkungan belajar yang lebih baik bersama SiPras.</p>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 bg-white text-blue-600 font-bold px-8 py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Mulai Sekarang — Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════ FOOTER ═══════════════ --}}
    <footer class="bg-gray-900 text-gray-400 py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="text-white font-bold">SiPras</span>
            </div>
            <p class="text-sm text-center sm:text-right">&copy; {{ date('Y') }} SiPras — Sistem Aspirasi Prasarana Sekolah</p>
        </div>
    </footer>

</body>