@extends('layouts.app')

@section('title', 'Login - SiPras')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-bold text-blue-600 mb-2">SiPras</h2>
            <p class="text-gray-600">Sistem Prasarana Sekolah</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Identifier Field -->
                <div>
                    <label for="identifier" class="block text-sm font-medium text-gray-700 mb-2">
                        Username / NIS
                    </label>
                    <input 
                        type="text" 
                        name="identifier" 
                        id="identifier" 
                        value="{{ old('identifier') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Masukkan username atau NIS"
                    >
                    @error('identifier')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Masukkan password"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg"
                >
                    Login
                </button>
            </form>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-xs text-blue-800">
                    <strong>Info:</strong> Admin login menggunakan username, Siswa login menggunakan NIS.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-6">
            &copy; {{ date('Y') }} SiPras - Sistem Prasarana Sekolah
        </p>
    </div>
</div>
@endsection
