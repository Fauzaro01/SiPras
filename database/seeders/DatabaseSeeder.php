<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Create Sample Aspirations
        Aspiration::create([
            'user_id' => $siswa1->id,
            'judul' => 'Kerusakan Meja di Kelas X-1',
            'deskripsi' => 'Terdapat beberapa meja yang rusak di kelas X-1. Kaki meja patah dan permukaan meja sudah tidak rata. Mohon segera diperbaiki karena mengganggu proses belajar.',
            'kategori' => 'Ruang Kelas',
            'lokasi' => 'Gedung A Lantai 2 Kelas X-1',
            'status' => 'pending',
        ]);

        Aspiration::create([
            'user_id' => $siswa2->id,
            'judul' => 'Toilet Lantai 1 Tidak Bersih',
            'deskripsi' => 'Toilet di lantai 1 dekat kantin kondisinya kurang bersih dan bau. Air sering tidak mengalir dengan baik.',
            'kategori' => 'Toilet',
            'lokasi' => 'Gedung A Lantai 1',
            'status' => 'diproses',
            'tanggapan_admin' => 'Terima kasih atas laporannya. Tim kebersihan sudah dijadwalkan untuk membersihkan area tersebut.',
        ]);

        Aspiration::create([
            'user_id' => $siswa3->id,
            'judul' => 'AC Laboratorium Komputer Rusak',
            'deskripsi' => 'AC di laboratorium komputer sudah tidak dingin. Membuat ruangan panas dan tidak nyaman untuk praktikum.',
            'kategori' => 'Laboratorium',
            'lokasi' => 'Gedung B Lantai 3 Lab Komputer',
            'status' => 'selesai',
            'tanggapan_admin' => 'AC sudah diperbaiki oleh teknisi. Terima kasih atas laporannya.',
        ]);

        Aspiration::create([
            'user_id' => $siswa1->id,
            'judul' => 'Lampu Perpustakaan Mati',
            'deskripsi' => 'Beberapa lampu di perpustakaan mati, membuat area baca menjadi gelap terutama di pojok ruangan.',
            'kategori' => 'Perpustakaan',
            'lokasi' => 'Gedung C Lantai 1 Perpustakaan',
            'status' => 'pending',
        ]);
    }
}
