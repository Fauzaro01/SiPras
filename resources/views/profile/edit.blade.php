@extends('layouts.dashboard')

@section('title', 'Edit Profil - SiPras')
@section('page-title', 'Edit Profil')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Edit Profil</h1>
            <p class="text-gray-500 text-sm mt-0.5">Perbarui informasi akun Anda</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="editProfileForm">
            @csrf @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" placeholder="Nama lengkap" required>
                @error('name')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Email (optional) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-gray-400">(opsional)</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" placeholder="email@domain.com">
                @error('email')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Avatar upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Avatar</label>
                <div class="flex items-center space-x-4">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">?</div>
                    @endif
                    <input type="file" name="avatar" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
                </div>
                @error('avatar')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Password (optional) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru <span class="text-gray-400">(kosongkan bila tidak ingin mengubah)</span></label>
                <div class="relative flex items-center">
                    <input type="password" name="password" id="password" class="w-full px-4 py-2.5 border rounded-lg text-sm pr-11 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" placeholder="Minimal 8 karakter, huruf besar & kecil, angka" autocomplete="new-password">
                    <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.543 7-1.274 4.057-5.064 7-9.543 7-4.477 0-8.268-2.943-9.543-7z"/></svg>
                    </button>
                </div>
                @error('password')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                <div class="relative flex items-center">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm pr-11 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="Ulangi password" autocomplete="new-password">
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.543 7-1.274 4.057-5.064 7-9.543 7-4.477 0-8.268-2.943-9.543-7z"/></svg>
                    </button>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-2">
                <a href="{{ route('dashboard') }}" class="flex-1 text-center px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm transition">Batal</a>
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg font-semibold text-sm shadow-sm transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    const icon = btn.querySelector('.eye-icon');
    if (isHidden) {
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
    } else {
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}
</script>
@endpush
