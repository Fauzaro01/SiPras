# Contributing to SiPras

Terima kasih sudah tertarik berkontribusi ke SiPras! 🎉

Berikut beberapa panduan agar proses kontribusi berjalan lancar dan konsisten.

## Alur Kontribusi

1. **Fork** repository ini.
2. Buat branch fitur baru:
   ```bash
   git checkout -b feature/NamaFitur
   ```
3. Lakukan perubahan, lalu **tulis test** untuk fitur/perbaikan yang kamu buat.
4. Jalankan test dan pastikan semua lulus:
   ```bash
   composer test
   ```
5. Jalankan pengecekan kode style (Pint):
   ```bash
   vendor/bin/pint
   ```
6. Commit dengan pesan yang jelas:
   ```bash
   git commit -m "feat: tambahkan fitur X"
   ```
7. Push ke branch dan buka **Pull Request**.

## Nama Branch & Commit

- Branch fitur: `feature/nama-fitur`
- Branch perbaikan bug: `fix/nama-bug`
- Pesan commit mengikuti **Conventional Commits**:
  - `feat:` fitur baru
  - `fix:` perbaikan bug
  - `docs:` perubahan dokumentasi
  - `refactor:` refactoring tanpa mengubah perilaku
  - `style:` perubahan format/style

## Standar Kode

- Ikuti gaya kode yang sudah ada (laravel preset).
- Gunakan **Pint** sebelum commit (`vendor/bin/pint`).
- Tulis test menggunakan **Pest** untuk setiap fitur baru.
- Selalu periksa Role-Based Access Control (RBAC) untuk setiap controller/admin route.

## Menjalankan Test

```bash
# Seluruh test
composer test

# Hanya test feature tertentu
php artisan test --filter=Siswa
```

## Melaporkan Bug / Fitur

- Buka **issue** menggunakan template yang sudah disediakan di `.github/ISSUE_TEMPLATE/`.
- Jelaskan langkah reproduksi, hasil yang diharapkan, dan hasil aktual.
- Untuk isu keamanan, jangan buat issue publik — lihat [SECURITY.md](SECURITY.md).

## Pertanyaan

Jika ada pertanyaan, silakan buka issue atau diskusi di repository.