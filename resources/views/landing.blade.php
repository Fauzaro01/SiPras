<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPras - Sistem Prasarana Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: .6; }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.7s ease-out forwards; }
        .animate-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animate-delay-200 { animation-delay: 0.2s; opacity: 0; }
        .animate-delay-300 { animation-delay: 0.3s; opacity: 0; }
        .animate-delay-400 { animation-delay: 0.4s; opacity: 0; }
        .gradient-text {
            background: linear-gradient(135deg, #1d4ed8, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #eff6ff 0%, #eef2ff 50%, #f0f9ff 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #4338ca);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        }
        .step-line::after {
            content: '';
            position: absolute;
            top: 2rem;
            left: calc(50% + 2.5rem);
            width: calc(100% - 5rem);
            height: 2px;
            background: linear-gradient(90deg, #bfdbfe, #c7d2fe);
        }
        .blob {
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }
    </style>
</head>
<body class="bg-white text-gray-800 overflow-x-hidden">

    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-blue-600 leading-none">SiPras</span>
                        <p class="text-xs text-gray-500 leading-none hidden sm:block">Sistem Prasarana Sekolah</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-1">
                    <a href="#fitur" class="text-gray-600 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition hover:bg-blue-50">Fitur</a>
                    <a href="#cara-kerja" class="text-gray-600 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition hover:bg-blue-50">Cara Kerja</a>
                    <a href="#tentang" class="text-gray-600 hover:text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition hover:bg-blue-50">Tentang</a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold px-4 py-2 rounded-lg transition hover:bg-blue-50">
                        Masuk
                    </a>
                    <a href="{{ route('login') }}" class="btn-primary text-white text-sm font-semibold px-5 py-2 rounded-lg shadow hidden sm:block">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-gradient min-h-screen flex items-center pt-16 relative overflow-hidden">
        <div class="absolute top-20 right-0 w-96 h-96 bg-blue-200/30 blob animate-float" style="animation-delay: 0s;"></div>
        <div class="absolute bottom-10 left-0 w-72 h-72 bg-indigo-200/30 blob animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/4 w-48 h-48 bg-sky-200/20 blob animate-float" style="animation-delay: 1s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left: Text --}}
                <div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6 animate-fade-in-up animate-delay-100">
                        Suarakan <span class="gradient-text">Aspirasi</span><br>
                        Prasarana <br class="hidden lg:block">Sekolahmu
                    </h1>

                    <p class="text-gray-500 text-lg leading-relaxed mb-8 max-w-xl animate-fade-in-up animate-delay-200">
                        SiPras memudahkan siswa untuk melaporkan kerusakan dan kebutuhan prasarana sekolah, serta memungkinkan admin merespon secara cepat dan terorganisir.
                    </p>

                    <div class="flex flex-wrap gap-4 animate-fade-in-up animate-delay-300">
                        <a href="{{ route('login') }}" class="btn-primary text-white font-bold px-8 py-4 rounded-xl shadow-lg text-base inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Login Sekarang
                        </a>
                        <a href="#cara-kerja" class="bg-white text-gray-700 font-bold px-8 py-4 rounded-xl shadow border border-gray-200 hover:shadow-md hover:border-blue-200 transition text-base inline-flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pelajari Lebih
                        </a>
                    </div>
                </div>

                <div class="relative animate-fade-in-up animate-delay-200">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-3xl blur-3xl opacity-20 scale-95"></div>
                    <div class="relative bg-white rounded-3xl shadow-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">Dashboard SiPras</h3>
                                <p class="text-sm text-gray-400">Ringkasan Aspirasi</p>
                            </div>
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3 mb-5">
                            <div class="bg-blue-50 rounded-xl p-3 text-center">
                                <p class="text-2xl font-bold text-blue-600">24</p>
                                <p class="text-xs text-gray-500 mt-0.5">Total</p>
                            </div>
                            <div class="bg-yellow-50 rounded-xl p-3 text-center">
                                <p class="text-2xl font-bold text-yellow-600">8</p>
                                <p class="text-xs text-gray-500 mt-0.5">Pending</p>
                            </div>
                            <div class="bg-green-50 rounded-xl p-3 text-center">
                                <p class="text-2xl font-bold text-green-600">12</p>
                                <p class="text-xs text-gray-500 mt-0.5">Selesai</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">Kerusakan Kursi Kelas XII-A</p>
                                    <p class="text-xs text-gray-400">Ruang Kelas · 2 jam lalu</p>
                                </div>
                                <span class="text-xs bg-yellow-100 text-yellow-700 font-semibold px-2 py-0.5 rounded-full flex-shrink-0">Pending</span>
                            </div>
                            <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
                                <div class="w-2 h-2 bg-blue-400 rounded-full flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">Proyektor Lab Komputer Rusak</p>
                                    <p class="text-xs text-gray-400">Lab Komputer · 1 hari lalu</p>
                                </div>
                                <span class="text-xs bg-blue-100 text-blue-700 font-semibold px-2 py-0.5 rounded-full flex-shrink-0">Proses</span>
                            </div>
                            <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
                                <div class="w-2 h-2 bg-green-400 rounded-full flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">Kipas Angin Perpustakaan Mati</p>
                                    <p class="text-xs text-gray-400">Perpustakaan · 3 hari lalu</p>
                                </div>
                                <span class="text-xs bg-green-100 text-green-700 font-semibold px-2 py-0.5 rounded-full flex-shrink-0">Selesai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 80L60 72C120 64 240 48 360 42.7C480 37.3 600 42.7 720 53.3C840 64 960 80 1080 80H1440V80H0Z" fill="white"/>
            </svg>
        </div>
    </section>

    <section class="bg-white py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-4xl font-extrabold gradient-text">500+</p>
                    <p class="text-gray-500 text-sm mt-1">Aspirasi Dilaporkan</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold gradient-text">95%</p>
                    <p class="text-gray-500 text-sm mt-1">Terselesaikan</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold gradient-text">200+</p>
                    <p class="text-gray-500 text-sm mt-1">Siswa Aktif</p>
                </div>
                <div>
                    <p class="text-4xl font-extrabold gradient-text">24/7</p>
                    <p class="text-gray-500 text-sm mt-1">Akses Kapan Saja</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FITUR SECTION ===== --}}
    <section id="fitur" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center mb-16">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-widest">Fitur Utama</span>
                <h2 class="text-4xl font-extrabold text-gray-800 mt-2">Kenapa Pilih SiPras?</h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto">Platform yang dirancang khusus untuk mempermudah komunikasi antara siswa dan pihak sekolah dalam mengelola prasarana.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-blue-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Lapor Mudah & Cepat</h3>
                    <p class="text-gray-500 leading-relaxed">Siswa bisa melaporkan kerusakan atau kebutuhan prasarana dalam hitungan detik. Form yang simpel dan intuitif.</p>
                    <div class="mt-5 flex items-center text-blue-600 text-sm font-semibold">
                        <span>Pelajari selengkapnya</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover relative">
                    <div class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded-full">Populer</div>
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-indigo-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Kelola Terorganisir</h3>
                    <p class="text-gray-500 leading-relaxed">Admin dapat melihat, menyortir, dan merespon semua laporan dengan tampilan yang rapi dan terstruktur.</p>
                    <div class="mt-5 flex items-center text-blue-600 text-sm font-semibold">
                        <span>Pelajari selengkapnya</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 card-hover">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-emerald-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Pantau Status Real-time</h3>
                    <p class="text-gray-500 leading-relaxed">Lacak perkembangan laporan dari Pending hingga Selesai secara transparan dan real-time kapan saja.</p>
                    <div class="mt-5 flex items-center text-blue-600 text-sm font-semibold">
                        <span>Pelajari selengkapnya</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Extra Features Row --}}
            <div class="grid md:grid-cols-3 gap-6 mt-8">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-start gap-4 card-hover">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Kategorisasi Laporan</h4>
                        <p class="text-sm text-gray-500 mt-1">Kelompokkan laporan berdasarkan jenis dan lokasi prasarana</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-start gap-4 card-hover">
                    <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Autentikasi Aman</h4>
                        <p class="text-sm text-gray-500 mt-1">Sistem login berbasis NIS untuk siswa dan username untuk admin</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-start gap-4 card-hover">
                    <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Dashboard Informatif</h4>
                        <p class="text-sm text-gray-500 mt-1">Statistik lengkap dan ringkasan laporan dalam satu tampilan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CARA KERJA ===== --}}
    <section id="cara-kerja" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-widest">Alur Kerja</span>
                <h2 class="text-4xl font-extrabold text-gray-800 mt-2">Cara Kerja SiPras</h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto">Proses pelaporan yang sederhana namun efektif, dari laporan masuk hingga terselesaikan.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-6 relative">
                {{-- Step 1 --}}
                <div class="text-center relative">
                    <div class="relative inline-block mb-5">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg shadow-blue-200 rotate-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        <span class="absolute -top-2 -right-2 w-6 h-6 bg-blue-600 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg mb-2">Login</h4>
                    <p class="text-sm text-gray-500">Masuk menggunakan NIS (siswa) atau username (admin)</p>
                    <div class="hidden md:block absolute top-8 left-[calc(50%+2rem)] right-[-50%] h-0.5 bg-gradient-to-r from-blue-200 to-indigo-200"></div>
                </div>

                {{-- Step 2 --}}
                <div class="text-center relative">
                    <div class="relative inline-block mb-5">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg shadow-indigo-200 -rotate-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <span class="absolute -top-2 -right-2 w-6 h-6 bg-indigo-600 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg mb-2">Buat Laporan</h4>
                    <p class="text-sm text-gray-500">Isi formulir laporan dengan detail lokasi dan deskripsi masalah</p>
                    <div class="hidden md:block absolute top-8 left-[calc(50%+2rem)] right-[-50%] h-0.5 bg-gradient-to-r from-indigo-200 to-purple-200"></div>
                </div>

                {{-- Step 3 --}}
                <div class="text-center relative">
                    <div class="relative inline-block mb-5">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg shadow-purple-200 rotate-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <span class="absolute -top-2 -right-2 w-6 h-6 bg-purple-600 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg mb-2">Diproses Admin</h4>
                    <p class="text-sm text-gray-500">Admin meninjau laporan dan memperbarui status penanganan</p>
                    <div class="hidden md:block absolute top-8 left-[calc(50%+2rem)] right-[-50%] h-0.5 bg-gradient-to-r from-purple-200 to-emerald-200"></div>
                </div>

                {{-- Step 4 --}}
                <div class="text-center">
                    <div class="relative inline-block mb-5">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg shadow-emerald-200 -rotate-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-600 text-white text-xs font-bold rounded-full flex items-center justify-center">4</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg mb-2">Selesai!</h4>
                    <p class="text-sm text-gray-500">Masalah terselesaikan dan laporan ditandai selesai secara transparan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== KATEGORI SECTION ===== --}}
    <section id="tentang" class="py-24 bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-blue-600 font-semibold text-sm uppercase tracking-widest">Tentang Platform</span>
                    <h2 class="text-4xl font-extrabold text-gray-800 mt-2 mb-5">Dibangun untuk Ekosistem Sekolah yang Lebih Baik</h2>
                    <p class="text-gray-500 leading-relaxed mb-6">
                        SiPras hadir sebagai solusi digital untuk menjembatani kebutuhan siswa dalam menyampaikan aspirasi terkait kondisi prasarana sekolah dengan tim pengelola yang bertugas menanganinya.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-gray-600">Transparan — Setiap laporan dapat dipantau statusnya secara real-time</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-gray-600">Akuntabel — Setiap penanganan tercatat dengan jelas oleh admin</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-gray-600">Efisien — Proses penanganan yang lebih cepat dan terstruktur</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-gray-600">Mudah Digunakan — Antarmuka yang simpel untuk semua kalangan</p>
                        </div>
                    </div>
                </div>

                {{-- Kategori Cards --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h5 class="font-semibold text-gray-800">Ruang Kelas</h5>
                        <p class="text-xs text-gray-500 mt-1">Kursi, meja, papan tulis, dll.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h5 class="font-semibold text-gray-800">Lab Komputer</h5>
                        <p class="text-xs text-gray-500 mt-1">PC, projektor, jaringan, dll.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h5 class="font-semibold text-gray-800">Perpustakaan</h5>
                        <p class="text-xs text-gray-500 mt-1">Rak buku, meja, fasilitas baca.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <h5 class="font-semibold text-gray-800">Fasilitas Umum</h5>
                        <p class="text-xs text-gray-500 mt-1">Toilet, kantin, lapangan, dll.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA BANNER ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-12 text-center overflow-hidden shadow-2xl">
                {{-- Background decoration --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>

                <div class="relative">
                    <h2 class="text-4xl font-extrabold text-white mb-4">Siap Menyuarakan Aspirasimu?</h2>
                    <p class="text-blue-100 text-lg mb-8 max-w-xl mx-auto">
                        Bergabunglah dan mulai laporkan kondisi prasarana sekolahmu. Bersama kita ciptakan lingkungan belajar yang lebih baik.
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-blue-600 font-bold px-10 py-4 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition text-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Mulai Sekarang — Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-10">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <span class="text-white font-bold text-xl">SiPras</span>
                    </div>
                    <p class="text-sm leading-relaxed">Platform aspirasi prasarana sekolah yang modern, transparan, dan mudah digunakan.</p>
                </div>

                {{-- Links --}}
                <div>
                    <h5 class="text-white font-semibold mb-4">Navigasi</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#fitur" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#cara-kerja" class="hover:text-white transition">Cara Kerja</a></li>
                        <li><a href="#tentang" class="hover:text-white transition">Tentang</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                    </ul>
                </div>

                {{-- Info --}}
                <div>
                    <h5 class="text-white font-semibold mb-4">Informasi Platform</h5>
                    <div class="bg-gray-800 rounded-xl p-4 text-sm space-y-2">
                        <p><span class="text-gray-300 font-medium">SiPras</span> adalah sebuah platform aspirasi prasarana sekolah yang modern, transparan, dan mudah digunakan.</p>
                        
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                <p class="text-sm">&copy; {{ date('Y') }} SiPras — Sistem Prasarana Sekolah. Hak cipta dilindungi.</p>
                <p class="text-xs text-gray-600">Dibuat dengan ❤️ untuk pendidikan yang lebih baik</p>
            </div>
        </div>
    </footer>

</body>
</html>
