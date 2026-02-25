@extends('layouts.dashboard')

@section('title', 'Buat Aspirasi - SiPras')
@section('page-title', 'Buat Aspirasi Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Buat Aspirasi Baru</h1>
            <p class="text-gray-500 text-sm mt-1">Sampaikan pengaduan prasarana sekolah Anda</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('aspirations.store') }}" class="space-y-5" enctype="multipart/form-data">
            @csrf

            <!-- Judul -->
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Judul Aspirasi <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="judul" 
                    id="judul" 
                    value="{{ old('judul') }}"
                    required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition"
                    placeholder="Contoh: Kerusakan Meja di Kelas X-1"
                >
                @error('judul')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="category_id" 
                        id="category_id" 
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition"
                    >
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="lokasi" 
                        id="lokasi" 
                        value="{{ old('lokasi') }}"
                        required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition"
                        placeholder="Contoh: Gedung A Lantai 2"
                    >
                    @error('lokasi')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Deskripsi Lengkap <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="deskripsi" 
                    id="deskripsi" 
                    rows="5"
                    required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition"
                    placeholder="Jelaskan detail masalah prasarana yang Anda temukan..."
                >{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bukti Foto -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Bukti Foto <span class="text-red-500">*</span>
                </label>

                {{-- Tab switcher --}}
                <div class="flex rounded-lg border border-gray-200 overflow-hidden mb-3 w-fit">
                    <button type="button" id="tab-upload" onclick="switchTab('upload')"
                        class="flex items-center gap-2 px-4 py-2 text-xs font-semibold transition bg-blue-600 text-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Upload File
                    </button>
                    <button type="button" id="tab-kamera" onclick="switchTab('kamera')"
                        class="flex items-center gap-2 px-4 py-2 text-xs font-semibold transition bg-white text-gray-500 hover:bg-gray-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Gunakan Kamera
                    </button>
                </div>

                {{-- Hidden file input (always in DOM for form submit) --}}
                <input type="file" name="bukti_foto" id="bukti_foto"
                    accept="image/jpg,image/jpeg,image/png,image/webp"
                    class="hidden" onchange="onFileSelected(this)">

                {{-- Panel: Upload --}}
                <div id="panel-upload">
                    <div id="dropzone"
                        class="relative border-2 border-dashed border-gray-300 rounded-xl hover:border-blue-400 transition-colors cursor-pointer bg-gray-50 hover:bg-blue-50/30"
                        onclick="document.getElementById('bukti_foto').click()">
                        <div id="dropzone-placeholder" class="flex flex-col items-center justify-center py-8 px-4 text-center">
                            <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-600">Klik untuk memilih foto</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, JPEG, PNG, WEBP · Maksimal 5 MB</p>
                        </div>
                        <div id="upload-preview" class="hidden py-4 px-4 flex flex-col items-center gap-3">
                            <img id="upload-preview-img" src="" alt="Preview" class="max-h-52 rounded-xl object-contain shadow-md">
                            <div class="flex items-center gap-2">
                                <p id="upload-preview-name" class="text-xs text-gray-500"></p>
                                <button type="button" onclick="event.stopPropagation();resetUpload()" class="text-xs text-red-500 hover:text-red-700 font-medium">Ganti</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Panel: Kamera --}}
                <div id="panel-kamera" class="hidden">
                    <div class="border-2 border-dashed border-gray-300 rounded-xl overflow-hidden bg-gray-900">

                        {{-- Camera stream --}}
                        <div id="camera-stream-wrap" class="relative">
                            <video id="camera-video" autoplay playsinline muted
                                class="w-full max-h-72 object-cover rounded-t-xl bg-black"></video>
                            <div class="absolute inset-0 flex items-center justify-center" id="camera-loading">
                                <div class="text-center text-white/70">
                                    <svg class="w-10 h-10 mx-auto mb-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="text-sm">Memuat kamera...</p>
                                </div>
                            </div>
                            {{-- Shutter overlay --}}
                            <div id="shutter-flash" class="absolute inset-0 bg-white opacity-0 pointer-events-none rounded-t-xl transition-opacity duration-75"></div>
                        </div>

                        {{-- Camera controls --}}
                        <div id="camera-controls" class="hidden items-center justify-between px-4 py-3 bg-gray-800">
                            <button type="button" onclick="flipCamera()"
                                class="flex items-center gap-1.5 text-white/70 hover:text-white text-xs transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Balik Kamera
                            </button>
                            <button type="button" onclick="capturePhoto()"
                                class="w-14 h-14 rounded-full bg-white hover:bg-gray-100 shadow-lg flex items-center justify-center transition active:scale-95">
                                <div class="w-11 h-11 rounded-full border-4 border-gray-400"></div>
                            </button>
                            <button type="button" onclick="stopCamera(); switchTab('upload')"
                                class="flex items-center gap-1.5 text-white/70 hover:text-red-400 text-xs transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Tutup
                            </button>
                        </div>

                        {{-- Camera error --}}
                        <div id="camera-error" class="hidden p-6 text-center bg-gray-800 rounded-b-xl">
                            <svg class="w-10 h-10 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-red-400 text-sm font-semibold">Kamera tidak dapat diakses</p>
                            <p id="camera-error-msg" class="text-gray-400 text-xs mt-1 max-w-xs mx-auto leading-relaxed">Pastikan izin kamera sudah diberikan di browser Anda</p>
                            <div class="flex justify-center gap-3 mt-4">
                                <button type="button" onclick="startCamera()"
                                    class="text-xs text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg transition font-medium">
                                    Coba Lagi
                                </button>
                                <button type="button" onclick="stopCamera(); switchTab('upload')"
                                    class="text-xs text-gray-300 hover:text-white border border-gray-600 hover:border-gray-400 px-3 py-1.5 rounded-lg transition">
                                    Pakai Upload
                                </button>
                            </div>
                        </div>

                        {{-- Photo result --}}
                        <div id="camera-result" class="hidden">
                            <img id="captured-img" src="" alt="Hasil Foto" class="w-full max-h-72 object-contain rounded-t-xl bg-black">
                            <div class="flex items-center justify-between px-4 py-3 bg-gray-800">
                                <button type="button" onclick="retakePhoto()"
                                    class="flex items-center gap-1.5 text-white/70 hover:text-white text-xs transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Foto Ulang
                                </button>
                                <span class="text-green-400 text-xs font-semibold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Foto berhasil diambil
                                </span>
                                <button type="button" onclick="stopCamera()"
                                    class="flex items-center gap-1.5 text-white/70 hover:text-white text-xs transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Gunakan Foto
                                </button>
                            </div>
                        </div>

                        <canvas id="capture-canvas" class="hidden"></canvas>
                    </div>
                </div>

                @error('bukti_foto')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4">
                <a href="{{ route('aspirations.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition text-sm text-center">
                    Batal
                </a>
                <button 
                    type="submit"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-sm hover:shadow-md transition text-sm"
                >
                    Kirim Aspirasi
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // ─── State ────────────────────────────────────────────────
    let currentStream = null;
    let facingMode   = 'environment'; // prefer back camera
    let capturedBlob = null;

    // ─── Tab switching ────────────────────────────────────────
    function switchTab(tab) {
        const isUpload = tab === 'upload';

        document.getElementById('panel-upload').classList.toggle('hidden', !isUpload);
        document.getElementById('panel-kamera').classList.toggle('hidden', isUpload);

        document.getElementById('tab-upload').className  = 'flex items-center gap-2 px-4 py-2 text-xs font-semibold transition ' + (isUpload  ? 'bg-blue-600 text-white' : 'bg-white text-gray-500 hover:bg-gray-50');
        document.getElementById('tab-kamera').className  = 'flex items-center gap-2 px-4 py-2 text-xs font-semibold transition ' + (!isUpload ? 'bg-blue-600 text-white' : 'bg-white text-gray-500 hover:bg-gray-50');

        if (!isUpload) {
            startCamera();
        } else {
            stopCamera();
        }
    }

    // ─── Upload file ──────────────────────────────────────────
    function onFileSelected(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        capturedBlob = null; // clear any camera capture
        const reader = new FileReader();
        reader.onload = e => showUploadPreview(e.target.result, file.name, file.size);
        reader.readAsDataURL(file);
    }

    function showUploadPreview(src, name, size) {
        document.getElementById('dropzone-placeholder').classList.add('hidden');
        const prev = document.getElementById('upload-preview');
        prev.classList.remove('hidden');
        prev.classList.add('flex');
        document.getElementById('upload-preview-img').src = src;
        document.getElementById('upload-preview-name').textContent = name + ' (' + (size / 1024).toFixed(1) + ' KB)';
        document.getElementById('dropzone').classList.add('border-blue-400', 'bg-blue-50/30');
        document.getElementById('dropzone').classList.remove('border-gray-300', 'bg-gray-50');
    }

    function resetUpload() {
        document.getElementById('bukti_foto').value = '';
        capturedBlob = null;
        document.getElementById('dropzone-placeholder').classList.remove('hidden');
        const prev = document.getElementById('upload-preview');
        prev.classList.add('hidden');
        prev.classList.remove('flex');
        document.getElementById('dropzone').classList.remove('border-blue-400', 'bg-blue-50/30');
        document.getElementById('dropzone').classList.add('border-gray-300', 'bg-gray-50');
    }

    // ─── Camera ───────────────────────────────────────────────
    async function startCamera() {
        document.getElementById('camera-loading').classList.remove('hidden');
        document.getElementById('camera-controls').classList.add('hidden');
        document.getElementById('camera-error').classList.add('hidden');
        document.getElementById('camera-result').classList.add('hidden');
        document.getElementById('camera-stream-wrap').classList.remove('hidden');

        stopCamera(); // stop any previous stream

        // Check for secure context and API support
        if (!window.isSecureContext) {
            document.getElementById('camera-loading').classList.add('hidden');
            document.getElementById('camera-error').classList.remove('hidden');
            document.getElementById('camera-error-msg').textContent =
                'Fitur kamera hanya tersedia pada koneksi HTTPS atau localhost. Gunakan tab "Upload File" sebagai alternatif.';
            return;
        }

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            document.getElementById('camera-loading').classList.add('hidden');
            document.getElementById('camera-error').classList.remove('hidden');
            document.getElementById('camera-error-msg').textContent =
                'Browser Anda tidak mendukung akses kamera. Coba gunakan Chrome atau Firefox versi terbaru.';
            return;
        }

        const constraints = {
            video: { facingMode, width: { ideal: 1280 }, height: { ideal: 720 } },
            audio: false
        };

        try {
            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            const video = document.getElementById('camera-video');
            video.srcObject = currentStream;
            video.onloadedmetadata = () => {
                video.play();
                document.getElementById('camera-loading').classList.add('hidden');
                document.getElementById('camera-controls').classList.remove('hidden');
                document.getElementById('camera-controls').classList.add('flex');
            };
        } catch (err) {
            document.getElementById('camera-loading').classList.add('hidden');
            document.getElementById('camera-error').classList.remove('hidden');
            const msgs = {
                'NotAllowedError'  : 'Izin kamera ditolak. Klik ikon kamera/gembok di address bar browser lalu izinkan akses kamera.',
                'NotFoundError'    : 'Tidak ada kamera yang ditemukan pada perangkat ini.',
                'NotReadableError' : 'Kamera sedang digunakan oleh aplikasi lain. Tutup aplikasi tersebut lalu coba lagi.',
                'OverconstrainedError': 'Kamera tidak mendukung resolusi yang diminta.',
                'SecurityError'    : 'Akses kamera diblokir oleh pengaturan keamanan browser.',
            };
            document.getElementById('camera-error-msg').textContent =
                msgs[err.name] || ('Error: ' + err.message);
        }
    }

    function stopCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(t => t.stop());
            currentStream = null;
        }
        const video = document.getElementById('camera-video');
        video.srcObject = null;
    }

    function flipCamera() {
        facingMode = facingMode === 'environment' ? 'user' : 'environment';
        startCamera();
    }

    function capturePhoto() {
        const video    = document.getElementById('camera-video');
        const canvas   = document.getElementById('capture-canvas');
        canvas.width   = video.videoWidth;
        canvas.height  = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);

        // Shutter flash
        const flash = document.getElementById('shutter-flash');
        flash.style.opacity = '0.9';
        setTimeout(() => flash.style.opacity = '0', 150);

        canvas.toBlob(blob => {
            capturedBlob = blob;
            const url = URL.createObjectURL(blob);
            document.getElementById('captured-img').src = url;

            // Inject blob into file input so the form can submit it
            const dt   = new DataTransfer();
            const file = new File([blob], 'kamera_' + Date.now() + '.jpg', { type: 'image/jpeg' });
            dt.items.add(file);
            document.getElementById('bukti_foto').files = dt.files;

            // Show result panel
            document.getElementById('camera-stream-wrap').classList.add('hidden');
            document.getElementById('camera-controls').classList.add('hidden');
            document.getElementById('camera-result').classList.remove('hidden');
        }, 'image/jpeg', 0.92);
    }

    function retakePhoto() {
        capturedBlob = null;
        document.getElementById('bukti_foto').value = '';
        document.getElementById('camera-result').classList.add('hidden');
        document.getElementById('camera-stream-wrap').classList.remove('hidden');
        startCamera();
    }

    // ─── Form validation ──────────────────────────────────────
    document.querySelector('form').addEventListener('submit', function(e) {
        const input = document.getElementById('bukti_foto');
        if (!input.files || input.files.length === 0) {
            e.preventDefault();
            alert('Silakan pilih atau ambil bukti foto terlebih dahulu.');
        }
    });

    // ─── Drag & drop support ──────────────────────────────────
    const dz = document.getElementById('dropzone');
    dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('border-blue-400'); });
    dz.addEventListener('dragleave', () => dz.classList.remove('border-blue-400'));
    dz.addEventListener('drop', e => {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (!file || !file.type.startsWith('image/')) return;
        const dt = new DataTransfer();
        dt.items.add(file);
        const input = document.getElementById('bukti_foto');
        input.files = dt.files;
        onFileSelected(input);
    });
</script>
@endpush
@endsection
