<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Aspiration;
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
        // Create Admin
        $admin = User::create([
            'name' => 'Admin SiPras',
            'username' => 'admin',
            'email' => 'admin@sipras.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Create Students
        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'nis' => '12345',
            'kelas' => 'X-1',
            'email' => 'budi@siswa.com',
            'role' => 'siswa',
            'password' => Hash::make('12345'),
        ]);

        $siswa2 = User::create([
            'name' => 'Siti Nurhaliza',
            'nis' => '12346',
            'kelas' => 'X-2',
            'email' => 'siti@siswa.com',
            'role' => 'siswa',
            'password' => Hash::make('12346'),
        ]);

        $siswa3 = User::create([
            'name' => 'Ahmad Fauzi',
            'nis' => '12347',
            'kelas' => 'XI-1',
            'email' => 'ahmad@siswa.com',
            'role' => 'siswa',
            'password' => Hash::make('12347'),
        ]);

        // Create Categories
        $catRuangKelas = Category::create([
            'nama' => 'Ruang Kelas',
            'deskripsi' => 'Aspirasi terkait kondisi ruang kelas',
        ]);

        $catToilet = Category::create([
            'nama' => 'Toilet',
            'deskripsi' => 'Aspirasi terkait kebersihan dan kondisi toilet',
        ]);

        $catLaboratorium = Category::create([
            'nama' => 'Laboratorium',
            'deskripsi' => 'Aspirasi terkait fasilitas laboratorium',
        ]);

        $catPerpustakaan = Category::create([
            'nama' => 'Perpustakaan',
            'deskripsi' => 'Aspirasi terkait fasilitas perpustakaan',
        ]);

        $catKantin = Category::create([
            'nama' => 'Kantin',
            'deskripsi' => 'Aspirasi terkait kantin dan makanan',
        ]);

        $catLapangan = Category::create([
            'nama' => 'Lapangan',
            'deskripsi' => 'Aspirasi terkait lapangan olahraga',
        ]);

        // Create Sample Aspirations
        Aspiration::create([
            'user_id' => $siswa1->id,
            'category_id' => $catRuangKelas->id,
            'judul' => 'Kerusakan Meja di Kelas X-1',
            'deskripsi' => 'Terdapat beberapa meja yang rusak di kelas X-1. Kaki meja patah dan permukaan meja sudah tidak rata. Mohon segera diperbaiki karena mengganggu proses belajar.',
            'lokasi' => 'Gedung A Lantai 2 Kelas X-1',
            'status' => 'diproses',
        ]);

        Aspiration::create([
            'user_id' => $siswa2->id,
            'category_id' => $catToilet->id,
            'judul' => 'Toilet Lantai 1 Tidak Bersih',
            'deskripsi' => 'Toilet di lantai 1 dekat kantin kondisinya kurang bersih dan bau. Air sering tidak mengalir dengan baik.',
            'lokasi' => 'Gedung A Lantai 1',
            'status' => 'diproses',
            'tanggapan_admin' => 'Terima kasih atas laporannya. Tim kebersihan sudah dijadwalkan untuk membersihkan area tersebut.',
        ]);

        Aspiration::create([
            'user_id' => $siswa3->id,
            'category_id' => $catLaboratorium->id,
            'judul' => 'AC Laboratorium Komputer Rusak',
            'deskripsi' => 'AC di laboratorium komputer sudah tidak dingin. Membuat ruangan panas dan tidak nyaman untuk praktikum.',
            'lokasi' => 'Gedung B Lantai 3 Lab Komputer',
            'status' => 'selesai',
            'tanggapan_admin' => 'AC sudah diperbaiki oleh teknisi. Terima kasih atas laporannya.',
        ]);

        Aspiration::create([
            'user_id' => $siswa1->id,
            'category_id' => $catPerpustakaan->id,
            'judul' => 'Lampu Perpustakaan Mati',
            'deskripsi' => 'Beberapa lampu di perpustakaan mati, membuat area baca menjadi gelap terutama di pojok ruangan.',
            'lokasi' => 'Gedung C Lantai 1 Perpustakaan',
            'status' => 'diproses',
        ]);

        Aspiration::create([
            'user_id' => $siswa2->id,
            'category_id' => $catKantin->id,
            'judul' => 'Kantin Kurang Variasi Menu',
            'deskripsi' => 'Menu makanan di kantin sangat monoton. Mohon ditambah variasi menu yang sehat dan bergizi untuk siswa.',
            'lokasi' => 'Kantin Sekolah',
            'status' => 'ditolak',
            'tanggapan_admin' => 'Terima kasih atas masukannya. Saat ini variasi menu sudah cukup memadai, akan dipertimbangkan ke depannya.',
        ]);
    }
}
