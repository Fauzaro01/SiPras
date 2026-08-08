<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        // Sample categories
        $categories = [
            ['nama' => 'Meja & Kursi', 'deskripsi' => 'Kerusakan atau kekurangan meja dan kursi'],
            ['nama' => 'Elektronik & Teknologi', 'deskripsi' => 'Perangkat elektronik seperti proyektor, komputer, AC'],
            ['nama' => 'Sanitasi & Kebersihan', 'deskripsi' => 'Fasilitas toilet, air bersih, kebersihan'],
            ['nama' => 'Penerangan & Listrik', 'deskripsi' => 'Lampu, instalasi listrik, penerangan ruangan'],
            ['nama' => 'Peralatan Olahraga', 'deskripsi' => 'Peralatan olahraga dan kondisi lapangan'],
            ['nama' => 'Perabot & Inventaris', 'deskripsi' => 'Perabot sekolah lainnya seperti lemari, papan tulis, rak'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
