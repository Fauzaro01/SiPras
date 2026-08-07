# Changelog

Semua perubahan penting pada proyek SiPras akan dicatat di file ini.

Format mengikuti [Keep a Changelog](https://keepachangelog.com/id/1.1.0/) dan versi mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Ditambahkan
- GitHub Actions CI otomatis (test Pest, kode style Pint, build Vite)
- Dokumentasi komunitas: `CONTRIBUTING.md`, `CODE_OF_CONDUCT.md`, `SECURITY.md`
- Templat issue (bug & fitur) dan templat pull request
- Tabel `feedbacks` untuk mendukung multiple tanggapan admin per aspirasi
- Upload foto bukti (`bukti_foto`) pada aspirasi

## [1.0.0] - 2026-02-26

### Ditambahkan
- Autentikasi multi-role (admin via username, siswa via NIS)
- Dashboard statistik aspirasi
- Manajemen aspirasi (buat, lihat, hapus, riwayat)
- Manajemen admin (users, categories, feedback)
- Interface responsif dengan Tailwind CSS + Vite
- Dukungan Docker (`docker-compose.yml`, `Dockerfile`)

[Unreleased]: https://github.com/fauzaro01/SiPras/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/fauzaro01/SiPras/releases/tag/v1.0.0