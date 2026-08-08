<?php

namespace Database\Seeders;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Admin ──
        $admin = User::create([
            'name' => 'Admin SiPras',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // ── Siswa ──
        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'nis' => '12345',
            'kelas' => 'X-1',
            'role' => 'siswa',
            'password' => Hash::make('12345'),
        ]);

        $siswa2 = User::create([
            'name' => 'Siti Nurhaliza',
            'nis' => '12346',
            'kelas' => 'X-2',
            'role' => 'siswa',
            'password' => Hash::make('12346'),
        ]);

        $siswa3 = User::create([
            'name' => 'Ahmad Fauzi',
            'nis' => '12347',
            'kelas' => 'XI-1',
            'role' => 'siswa',
            'password' => Hash::make('12347'),
        ]);

        // ── Kategori ──
        $catMejaKursi = Category::create(['nama' => 'Meja & Kursi',            'deskripsi' => 'Aspirasi terkait kerusakan atau kekurangan meja dan kursi']);
        $catElektronik = Category::create(['nama' => 'Elektronik & Teknologi',  'deskripsi' => 'Aspirasi terkait perangkat elektronik seperti proyektor, komputer, dan AC']);
        $catSanitasi = Category::create(['nama' => 'Sanitasi & Kebersihan',   'deskripsi' => 'Aspirasi terkait fasilitas toilet, air bersih, dan kebersihan']);
        $catPenerangan = Category::create(['nama' => 'Penerangan & Listrik',    'deskripsi' => 'Aspirasi terkait lampu, instalasi listrik, dan penerangan ruangan']);
        $catOlahraga = Category::create(['nama' => 'Peralatan Olahraga',      'deskripsi' => 'Aspirasi terkait peralatan olahraga dan kondisi lapangan']);
        $catPerabot = Category::create(['nama' => 'Perabot & Inventaris',    'deskripsi' => 'Aspirasi terkait perabot sekolah lainnya seperti lemari, papan tulis, dan rak']);

        // ── Aspirasi ──

        // 1. Baru diajukan (belum ada feedback)
        $asp1 = Aspiration::create([
            'user_id' => $siswa1->id,
            'category_id' => $catMejaKursi->id,
            'judul' => 'Kerusakan Meja di Kelas X-1',
            'deskripsi' => 'Terdapat beberapa meja yang rusak di kelas X-1. Kaki meja patah dan permukaan meja sudah tidak rata. Mohon segera diperbaiki karena mengganggu proses belajar.',
            'lokasi' => 'Gedung A Lantai 2 Kelas X-1',
            'status' => 'diajukan',
        ]);

        // 2. Sedang diproses + feedback admin
        $asp2 = Aspiration::create([
            'user_id' => $siswa2->id,
            'category_id' => $catSanitasi->id,
            'judul' => 'Toilet Lantai 1 Tidak Bersih',
            'deskripsi' => 'Toilet di lantai 1 dekat kantin kondisinya kurang bersih dan bau. Air sering tidak mengalir dengan baik.',
            'lokasi' => 'Gedung A Lantai 1',
            'status' => 'diproses',
        ]);
        Feedback::create([
            'aspiration_id' => $asp2->id,
            'user_id' => $admin->id,
            'pesan' => 'Terima kasih atas laporannya. Tim kebersihan sudah dijadwalkan untuk membersihkan area tersebut pada hari Senin.',
        ]);

        // 3. Selesai + dua feedback
        $asp3 = Aspiration::create([
            'user_id' => $siswa3->id,
            'category_id' => $catElektronik->id,
            'judul' => 'AC Laboratorium Komputer Rusak',
            'deskripsi' => 'AC di laboratorium komputer sudah tidak dingin. Membuat ruangan panas dan tidak nyaman untuk praktikum.',
            'lokasi' => 'Gedung B Lantai 3 Lab Komputer',
            'status' => 'selesai',
        ]);
        Feedback::create([
            'aspiration_id' => $asp3->id,
            'user_id' => $admin->id,
            'pesan' => 'Laporan sudah kami terima. Teknisi dijadwalkan untuk memeriksa AC pada hari Rabu.',
        ]);
        Feedback::create([
            'aspiration_id' => $asp3->id,
            'user_id' => $admin->id,
            'pesan' => 'AC sudah berhasil diperbaiki oleh teknisi. Terima kasih atas laporannya!',
        ]);

        // 4. Masih diajukan
        $asp4 = Aspiration::create([
            'user_id' => $siswa1->id,
            'category_id' => $catPenerangan->id,
            'judul' => 'Lampu Perpustakaan Mati',
            'deskripsi' => 'Beberapa lampu di perpustakaan mati, membuat area baca menjadi gelap terutama di pojok ruangan.',
            'lokasi' => 'Gedung C Lantai 1 Perpustakaan',
            'status' => 'diajukan',
        ]);

        // 5. Ditolak + feedback alasan
        $asp5 = Aspiration::create([
            'user_id' => $siswa2->id,
            'category_id' => $catPerabot->id,
            'judul' => 'Kantin Kurang Variasi Menu',
            'deskripsi' => 'Menu makanan di kantin sangat monoton. Mohon ditambah variasi menu yang sehat dan bergizi untuk siswa.',
            'lokasi' => 'Kantin Sekolah',
            'status' => 'ditolak',
        ]);
        Feedback::create([
            'aspiration_id' => $asp5->id,
            'user_id' => $admin->id,
            'pesan' => 'Terima kasih atas masukannya. Pengelolaan menu kantin berada di luar wewenang kami. Saran sudah diteruskan ke pihak kantin untuk dipertimbangkan.',
        ]);

        // 6. Diproses + feedback
        $asp6 = Aspiration::create([
            'user_id' => $siswa3->id,
            'category_id' => $catOlahraga->id,
            'judul' => 'Lapangan Basket Berlubang',
            'deskripsi' => 'Terdapat beberapa lubang di lapangan basket yang berpotensi menyebabkan cedera saat berolahraga.',
            'lokasi' => 'Lapangan Basket Sekolah',
            'status' => 'diproses',
        ]);
        Feedback::create([
            'aspiration_id' => $asp6->id,
            'user_id' => $admin->id,
            'pesan' => 'Laporan sudah diterima. Perbaikan dijadwalkan pada minggu ini.',
        ]);
    }
}
