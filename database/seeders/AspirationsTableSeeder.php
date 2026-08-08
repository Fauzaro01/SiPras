<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aspiration;
use App\Models\User;
use App\Models\Category;

class AspirationsTableSeeder extends Seeder
{
    public function run()
    {
        // Generate 20 aspirations with random status and priority
        Aspiration::factory()->count(20)->create();
    }
}
