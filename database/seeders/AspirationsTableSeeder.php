<?php

namespace Database\Seeders;

use App\Models\Aspiration;
use Illuminate\Database\Seeder;

class AspirationsTableSeeder extends Seeder
{
    public function run()
    {
        // Generate 20 aspirations with random status and priority
        Aspiration::factory()->count(20)->create();
    }
}
