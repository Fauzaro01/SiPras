<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiPras - Sistem Prasarana Sekolah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
    <style>
        .sidebar-link {
            transition: all 0.15s ease;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: #eff6ff;
            color: #2563eb;
        }
        .sidebar-link.active {
            border-right: 3px solid #2563eb;
        }
    </style>
    <script>
        // Check local storage or media query for dark mode preference
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">

    {{-- Mobile Overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" class="fixed top-0 left-0 z-50 h-screen w-64 bg-white border-r border-gray-200 shadow-sm transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
        {{-- Logo --}}
        <div class="flex items-center space-x-2.5 px-5 h-16 border-b border-gray-100 flex-shrink-0">
            <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center shadow">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <span class="text-lg font-bold text-blue-600 leading-none">SiPras</span>
                <p class="text-[10px] text-gray-400 leading-none mt-0.5">Sistem Prasarana Sekolah</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <p class="px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Menu Utama</p>
            
            <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('aspirations.index') }}" class="sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 {{ request()->routeIs('aspirations.index', 'aspirations.create', 'aspirations.show', 'aspirations.edit') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Aspirasi</span>
                </div>
                @if(Auth::user()->isAdmin() && isset($sidebarBadges['pending_aspirations']) && $sidebarBadges['pending_aspirations'] > 0)
                    <span class="bg-yellow-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 animate-pulse">
                        {{ $sidebarBadges['pending_aspirations'] }}
                    </span>
                @elseif(Auth::user()->isSiswa() && isset($sidebarBadges['active_aspirations']) && $sidebarBadges['active_aspirations'] > 0)
                    <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0">
                        {{ $sidebarBadges['active_aspirations'] }}
                    </span>
                @endif
            </a>

            @if(Auth::user()->isSiswa())
                <a href="{{ route('aspirations.histori') }}" class="sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 {{ request()->routeIs('aspirations.histori') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Histori Aspirasi</span>
                    </div>
                    @if(isset($sidebarBadges['history_aspirations']) && $sidebarBadges['history_aspirations'] > 0)
                        <span class="bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0">
                            {{ $sidebarBadges['history_aspirations'] }}
                        </span>
                    @endif
                </a>
            @endif

            @if(Auth::user()->isAdmin())
                <p class="px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 mt-6">Admin</p>

                <a href="{{ route('aspirations.histori') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 {{ request()->routeIs('aspirations.histori') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Histori Aspirasi
                </a>
                
                <a href="{{ route('categories.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Kategori
                </a>

                <a href="{{ route('users.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Pengguna
                </a>
            @endif
        </nav>

        {{-- User info at bottom --}}
        <div class="flex-shrink-0 border-t border-gray-100 px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ ucfirst(Auth::user()->role) }}{{ Auth::user()->nis ? ' · ' . Auth::user()->nis : '' }}</p>
                </div>
                <a href="{{ route('password.change') }}" title="Ganti Password" class="p-1.5 rounded-lg text-gray-400 hover:text-blue-500 hover:bg-blue-50 transition {{ request()->routeIs('password.change') ? 'text-blue-500 bg-blue-50' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout" class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="lg:ml-64 min-h-screen flex flex-col">
        {{-- Top bar --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-4 sm:px-6 h-16">
                {{-- Hamburger (mobile) --}}
                <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Page title --}}
                <h2 class="text-lg font-bold text-gray-800 hidden lg:block">@yield('page-title', 'Dashboard')</h2>

                {{-- Global Search Bar (F-06) --}}
                <div class="hidden md:block flex-1 max-w-xs lg:max-w-md mx-6">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari aspirasi, pelapor, kategori..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-gray-50 focus:bg-white transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </form>
                </div>
                
                {{-- Mobile logo --}}
                <span class="text-lg font-bold text-blue-600 lg:hidden">SiPras</span>

                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    <!-- Dark Mode Toggle Button (F-16) -->
                    <button id="theme-toggle" type="button" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors duration-200" title="Ubah Tema">
                        <!-- Sun Icon (for dark mode active) -->
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728A9 9 0 115.636 5.636m12.728 12.728L12 12"/>
                        </svg>
                        <!-- Moon Icon (for light mode active) -->
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    <span class="hidden sm:inline-block text-sm text-gray-500">
                        {{ Auth::user()->name }}
                    </span>
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Content area --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // ─── SweetAlert2 Toast helper ───
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @if(session('success'))
            Toast.fire({ icon: 'success', title: @json(session('success')) });
        @endif
        @if(session('error'))
            Toast.fire({ icon: 'error', title: @json(session('error')) });
        @endif

        // ─── Global: intercept forms with data-confirm ───
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const msg  = form.dataset.confirm;
            if (!msg) return;
            if (form.dataset.confirmed === 'yes') return;
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = 'yes';
                    form.submit();
                }
            });
        });

        // ─── Dark Mode Toggle Handler (F-16) ───
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (document.documentElement.classList.contains('dark')) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
