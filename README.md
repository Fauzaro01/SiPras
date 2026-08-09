# SiPras - Sistem Prasarana Sekolah

<div align="center">
 
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D%208.2-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-4-06B6D4?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)
[![Pest](https://img.shields.io/badge/Test-Pest-green?style=flat-square&logo=php)](build)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

[![CI](https://github.com/fauzaro01/SiPras/actions/workflows/ci.yml/badge.svg)](https://github.com/fauzaro01/SiPras/actions)
[![Contributions Welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat-square)](CONTRIBUTING.md)

Aplikasi web modern untuk mengelola dan merespons aspirasi/pengaduan prasarana sekolah.

</div>

## Tentang Proyek

**SiPras** adalah sistem informasi berbasis web yang dirancang untuk memfasilitasi komunikasi antara siswa dan manajemen sekolah dalam mengelola kerusakan atau masalah prasarana sekolah. Siswa dapat dengan mudah melaporkan masalah prasarana, sementara admin dapat mengelola, merespons, dan melacak status setiap laporan.

## 🎯 Fitur Utama

- **Autentikasi Multi-Role**:
    - Admin login dengan username
    - Siswa login dengan NIS (Nomor Induk Siswa)

- **Dashboard Statistik**:
    - Ringkasan total aspirasi
    - Grafik distribusi berdasarkan status (pending, ditanggapi, ditutup)
    - Statistik perbulan

- **Manajemen Aspirasi**:
    - Siswa dapat membuat aspirasi baru dengan kategori, deskripsi, dan lokasi
    - Upload foto bukti kerusakan
    - Melihat riwayat aspirasi mereka
    - Menghapus aspirasi mereka sendiri

- **Pengelolaan Admin**:
    - Melihat semua aspirasi dari seluruh siswa
    - Filter dan pencarian aspirasi
    - Mengubah status aspirasi (pending, ditanggapi, ditutup)
    - Memberikan tanggapan/respon terhadap laporan

- **Interface Modern**:
    - Desain responsif menggunakan Tailwind CSS
    - UI intuitif dan mudah digunakan
    - Kompatibel dengan perangkat desktop dan mobile

## 🛠️ Teknologi

| Teknologi            | Versi | Deskripsi                   |
| -------------------- | ----- | --------------------------- |
| **Laravel**          | 12    | Framework PHP modern        |
| **PHP**              | ≥ 8.2 | Bahasa pemrograman backend  |
| **Tailwind CSS**     | 4     | Framework CSS untuk styling |
| **Vite**             | 7+    | Build tool cepat            |
| **MySQL/PostgreSQL** | -     | Database relasional         |
| **Composer**         | -     | Package manager PHP         |
| **NPM**              | -     | Package manager JavaScript  |
| **Pest**             | 4     | Framework pengujian         |

## 📝 Status Aspirasi

Alur status pada aplikasi:

```
diajukan → diproses → selesai
                    ↘ ditolak
```

Setiap aspirasi memiliki 4 status: `diajukan`, `diproses`, `selesai`, dan `ditolak`. Siswa dapat melihat progress melalui halaman detail, sementara admin mengubah status melalui panel pengelolaan.

## 📦 Instalasi

### Prasyarat

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js dan NPM
- Database server (MySQL atau PostgreSQL)

### Langkah-langkah

1. **Clone atau setup project**

    ```bash
    cd c:\Users\Fauzaro01\Documents\Github\SiPras
    ```

2. **Install dependencies PHP dan JavaScript**

    ```bash
    composer install
    npm install
    ```

3. **Setup environment**

    ```bash
    copy .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi database** (edit file `.env`)

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sipras
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Jalankan migrasi database**

    ```bash
    php artisan migrate:fresh --seed
    ```

6. **Build assets (development)**

    ```bash
    npm run dev
    ```

7. **Jalankan aplikasi**

    ```bash
    php artisan serve
    ```

8. **Akses aplikasi**
   Buka browser dan akses: `http://localhost:8000`

## 👤 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk testing:

### Admin

| Field        | Nilai      |
| ------------ | ---------- |
| **Username** | `admin`    |
| **Password** | `admin123` |

### Siswa

| NIS     | Password | Nama           | Kelas |
| ------- | -------- | -------------- | ----- |
| `12345` | `12345`  | Budi Santoso   | X-1   |
| `12346` | `12346`  | Siti Nurhaliza | X-2   |
| `12347` | `12347`  | Ahmad Fauzi    | XI-1  |

## 🧪 Testing

Projek ini menggunakan **Pest** untuk pengujian otomatis (dijalankan secara otomatis di CI).

```bash
# Menjalankan seluruh test
composer test
# atau
php artisan test

# Menjalankan test untuk modul tertentu
php artisan test --filter=Siswa
php artisan test --filter=Admin

# Pengecekan kode style (Pint)
vendor/bin/pint
```

## 🐳 Docker (Opsional)

Proyek menyertakan konfigurasi Docker. Lihat `docker-compose.yml` dan `Dockerfile`.

```bash
docker compose up -d --build
```

## 📊 Struktur Database

### Tabel Users

| Field      | Tipe    | Deskripsi                       |
| ---------- | ------- | ------------------------------- |
| `id`       | INT     | Primary key                     |
| `name`     | VARCHAR | Nama lengkap pengguna           |
| `email`    | VARCHAR | Email (opsional)                |
| `username` | VARCHAR | Username untuk admin (opsional) |
| `nis`      | VARCHAR | NIS untuk siswa (opsional)      |
| `role`     | ENUM    | Role pengguna: admin atau siswa |
| `kelas`    | VARCHAR | Kelas siswa (opsional)          |
| `password` | VARCHAR | Password terenkripsi            |

### Tabel Categories

| Field       | Tipe    | Deskripsi               |
| ----------- | ------- | ----------------------- |
| `id`        | INT     | Primary key             |
| `nama`      | VARCHAR | Nama kategori prasarana |
| `deskripsi` | TEXT    | Deskripsi kategori      |

### Tabel Aspirations

| Field         | Tipe      | Deskripsi                            |
| ------------- | --------- | ------------------------------------ |
| `id`          | INT       | Primary key                          |
| `user_id`     | INT       | Foreign key ke tabel users           |
| `category_id` | INT       | Foreign key ke tabel categories      |
| `judul`       | VARCHAR   | Judul aspirasi                       |
| `deskripsi`   | TEXT      | Deskripsi lengkap masalah            |
| `lokasi`      | VARCHAR   | Lokasi detail masalah                |
| `bukti_foto`  | VARCHAR   | Path file foto bukti (opsional)      |
| `status`      | ENUM      | Status: pending, ditanggapi, ditutup |
| `tanggapan`   | TEXT      | Tanggapan dari admin (opsional)      |
| `created_at`  | TIMESTAMP | Waktu pembuatan                      |
| `updated_at`  | TIMESTAMP | Waktu terakhir diupdate              |

## 🚀 Menjalankan Development

### Development dengan Watch Mode

```bash
npm run dev
```

### Production Build

```bash
npm run build
```

### Artisan Commands yang Berguna

```bash
# Membuat migration baru
php artisan make:migration nama_migration

# Membuat model baru
php artisan make:model NamaModel

# Membuat controller
php artisan make:controller NamaController

# Reset database
php artisan migrate:reset

# Seed database
php artisan db:seed
```

## 📁 Struktur Folder

```
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Controller aplikasi
│   │   └── Middleware/       # Middleware
│   ├── Models/               # Eloquent models
│   └── Providers/            # Service providers
├── bootstrap/                # Bootstrap aplikasi
├── config/                   # File konfigurasi
├── database/
│   ├── migrations/           # Database migrations
│   ├── factories/            # Model factories
│   └── seeders/              # Database seeders
├── public/                   # File publik
├── resources/
│   ├── css/                  # CSS files
│   ├── js/                   # JavaScript files
│   └── views/                # Blade templates
├── routes/                   # Route definitions
├── storage/                  # File penyimpanan
├── tests/                    # Test files
└── vendor/                   # Dependencies (auto-generated)
```

## 🔐 Keamanan

- Password disimpan dengan hashing bcrypt
- CSRF protection pada semua form
- Role-based access control (RBAC)
- Input validation pada semua endpoints

## 📝 Lisensi

Proyek ini dilisensikan di bawah lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail lengkapnya.

## 👨‍💻 Kontribusi

Kontribusi sangat diterima! Untuk berkontribusi:

1. Baca panduan di [CONTRIBUTING.md](CONTRIBUTING.md)
2. Fork repository ini
3. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
4. Commit perubahan (`git commit -m 'feat: Add some AmazingFeature'`)
5. Push ke branch (`git push origin feature/AmazingFeature`)
6. Buka Pull Request

Harap perhatikan [Kode Etik](CODE_OF_CONDUCT.md) dan tinjau kebijakan keamanan di [SECURITY.md](SECURITY.md).

## 📧 Dukungan

Jika Anda memiliki pertanyaan atau menemukan bug, silakan buka issue di repository ini menggunakan template yang telah disediakan.

## 📅 Changelog

### v1.0.0 (2026-02-26)

- Initial release
- Fitur autentikasi multi-role
- Dashboard statistik
- Manajemen aspirasi
- Pengelolaan admin

---

**Dibuat dengan ❤️ menggunakan Laravel dan Tailwind CSS**
