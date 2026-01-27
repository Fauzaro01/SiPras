<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPras - Sistem Prasarana Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-16">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-6xl font-bold text-blue-600 mb-4">SiPras</h1>
            <p class="text-2xl text-gray-700 mb-2">Sistem Prasarana Sekolah</p>
            <p class="text-gray-600">Platform untuk melaporkan dan mengelola aspirasi prasarana sekolah</p>
        </div>

        <!-- Features -->
        <div class="grid md:grid-cols-3 gap-8 mb-16 max-w-6xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Lapor Mudah</h3>
                <p class="text-gray-600">Siswa dapat melaporkan kerusakan prasarana dengan mudah dan cepat</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Kelola Efisien</h3>
                <p class="text-gray-600">Admin dapat mengelola dan merespon laporan secara terorganisir</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tracking Jelas</h3>
                <p class="text-gray-600">Pantau status laporan dari pending hingga selesai dengan transparan</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Siap Memulai?</h2>
            <p class="text-gray-600 mb-6">Login untuk mulai melaporkan atau mengelola aspirasi prasarana sekolah</p>
            <a href="/login" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 rounded-lg text-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                Login Sekarang →
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center mt-16 text-gray-600">
            <p>&copy; {{ date('Y') }} SiPras - Sistem Prasarana Sekolah</p>
        </div>
    </div>
</body>
</html>
