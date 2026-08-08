@extends('layouts.dashboard')

@section('title', 'Tambah Pengguna - SiPras')
@section('page-title', 'Tambah Pengguna')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('users.index') }}" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Tambah Pengguna Baru</h1>
            <p class="text-gray-500 text-sm mt-0.5">Daftarkan akun pengguna baru ke SiPras</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-5" id="createUserForm">
            @csrf

            <!-- Role selector -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Role Pengguna <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="role-option relative cursor-pointer">
                        <input type="radio" name="role" value="siswa" class="sr-only" {{ old('role', 'siswa') === 'siswa' ? 'checked' : '' }} onchange="updateFormFields()">
                        <div class="role-card border-2 rounded-xl p-4 text-center transition-all {{ old('role', 'siswa') === 'siswa' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-800 text-sm">Siswa</p>
                            <p class="text-xs text-gray-400 mt-0.5">Login dengan NIS</p>
                        </div>
                    </label>
                    <label class="role-option relative cursor-pointer">
                        <input type="radio" name="role" value="admin" class="sr-only" {{ old('role') === 'admin' ? 'checked' : '' }} onchange="updateFormFields()">
                        <div class="role-card border-2 rounded-xl p-4 text-center transition-all {{ old('role') === 'admin' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-800 text-sm">Admin</p>
                            <p class="text-xs text-gray-400 mt-0.5">Login dengan username</p>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                        {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    placeholder="Nama lengkap pengguna"
                    required
                >
                @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Siswa Fields -->
            <div id="siswaFields" class="{{ old('role') === 'admin' ? 'hidden' : '' }} space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            NIS <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nis"
                            value="{{ old('nis') }}"
                            class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                                {{ $errors->has('nis') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                            placeholder="Nomor Induk Siswa"
                        >
                        @error('nis')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kelas</label>
                        <input
                            type="text"
                            name="kelas"
                            value="{{ old('kelas') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Contoh: X-1"
                        >
                    </div>
                </div>
            </div>

            <!-- Admin Fields -->
            <div id="adminFields" class="{{ old('role') !== 'admin' ? 'hidden' : '' }} space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                            {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="Username untuk login"
                    >
                    @error('username')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Password <span class="text-red-500">*</span>
                </label>
                <div class="relative flex items-center">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="w-full px-4 py-2.5 border rounded-lg text-sm pr-11 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                            {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <div class="relative flex items-center">
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm pr-11 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Ulangi password"
                        required
                    >
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2">
                <a href="{{ route('users.index') }}" class="flex-1 text-center px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm transition">
                    Batal
                </a>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-semibold text-sm shadow-sm transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Tambah Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateFormFields() {
        const selectedRole = document.querySelector('input[name="role"]:checked')?.value;
        const siswaFields = document.getElementById('siswaFields');
        const adminFields = document.getElementById('adminFields');

        if (selectedRole === 'admin') {
            siswaFields.classList.add('hidden');
            adminFields.classList.remove('hidden');
        } else {
            siswaFields.classList.remove('hidden');
            adminFields.classList.add('hidden');
        }

        // Update card styles
        document.querySelectorAll('.role-option').forEach(opt => {
            const card = opt.querySelector('.role-card');
            const radio = opt.querySelector('input[type="radio"]');
            if (radio.checked) {
                card.classList.add('border-blue-500', 'bg-blue-50');
                card.classList.remove('border-gray-200');
            } else {
                card.classList.remove('border-blue-500', 'bg-blue-50');
                card.classList.add('border-gray-200');
            }
        });
    }

    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';

        const icon = btn.querySelector('.eye-icon');
        if (isHidden) {
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }

    // Attach click event to role cards too
    document.querySelectorAll('.role-option').forEach(opt => {
        opt.addEventListener('click', updateFormFields);
    });
</script>
@endpush
