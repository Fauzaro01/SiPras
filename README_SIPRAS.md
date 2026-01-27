# SiPras - Sistem Prasarana Sekolah

Aplikasi web untuk mengelola aspirasi/pengaduan prasarana sekolah. Siswa dapat melaporkan kerusakan atau masalah prasarana, dan admin dapat mengelola serta merespons laporan tersebut.

## Fitur

- **Autentikasi Multi-Role**: Admin login dengan username, Siswa login dengan NIS
- **Dashboard Statistik**: Menampilkan ringkasan aspirasi berdasarkan status
- **Manajemen Aspirasi**: Siswa dapat membuat, melihat, dan menghapus aspirasi mereka
- **Pengelolaan Admin**: Admin dapat melihat semua aspirasi, mengubah status, dan memberikan tanggapan
- **UI Modern**: Desain responsif dengan Tailwind CSS

## Teknologi

- Laravel 11
- Tailwind CSS 4
- MySQL/PostgreSQL
- Vite

## Instalasi

1. **Clone atau setup project**
   ```bash
   cd c:\Users\Fauzaro01\Documents\Project\SiPras
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sipras
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Compile assets**
   ```bash
   npm run dev
   ```

7. **Jalankan aplikasi**
   Buka terminal baru dan jalankan:
   ```bash
   php artisan serve
   ```

8. **Akses aplikasi**
   Buka browser dan akses: `http://localhost:8000`

## Akun Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin
- **Username**: `admin`
- **Password**: `admin123`

### Siswa
- **NIS**: `12345` | **Password**: `12345` | **Nama**: Budi Santoso (Kelas X-1)
- **NIS**: `12346` | **Password**: `12346` | **Nama**: Siti Nurhaliza (Kelas X-2)
- **NIS**: `12347` | **Password**: `12347` | **Nama**: Ahmad Fauzi (Kelas XI-1)

## Struktur Database

### Tabel Users
- `id`: Primary key
- `name`: Nama lengkap
- `email`: Email (nullable)
- `username`: Username untuk admin (nullable)
- `nis`: Nomor Induk Siswa untuk siswa (nullable)
- `role`: Role pengguna (admin/siswa)
- `kelas`: Kelas siswa (nullable)
- `password`: Password (hashed)

### Tabel Aspirations
- `id`: Primary key
- `user_id`: Foreign key ke tabel users
- `judul`: Judul aspirasi
- `deskripsi`: Deskripsi lengkap masalah
- `kategori`: Kategori prasarana (Ruang Kelas, Toilet, Laboratorium, dll)
- `lokasi`: Lokasi detail masalah
- `status`: Status aspirasi (pending, diproses, selesai, ditolak)
- `tanggapan_admin`: Tanggapan dari admin (nullable)

## Penggunaan

### Untuk Siswa
1. Login menggunakan NIS dan password
2. Lihat dashboard dengan statistik aspirasi Anda
3. Buat aspirasi baru dengan mengisi form lengkap
4. Lihat status dan tanggapan admin pada aspirasi Anda
5. Hapus aspirasi yang masih berstatus pending

### Untuk Admin
1. Login menggunakan username dan password
2. Lihat dashboard dengan statistik semua aspirasi
3. Kelola semua aspirasi dari siswa
4. Update status aspirasi (pending → diproses → selesai/ditolak)
5. Berikan tanggapan kepada siswa

## Status Aspirasi

- **Pending** (Kuning): Aspirasi baru yang belum ditangani
- **Diproses** (Biru): Aspirasi sedang dalam proses penanganan
- **Selesai** (Hijau): Masalah sudah diselesaikan
- **Ditolak** (Merah): Aspirasi ditolak dengan alasan tertentu

## Development

Untuk development dengan hot reload:
```bash
npm run dev
```

Untuk build production:
```bash
npm run build
```

## Lisensi

Project ini dibuat untuk keperluan sistem prasarana sekolah.
