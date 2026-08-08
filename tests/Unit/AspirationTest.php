<?php

namespace Tests\Unit;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspirationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aspiration_belongs_to_user_and_category()
    {
        $aspiration = Aspiration::factory()->create();
        $this->assertInstanceOf(User::class, $aspiration->user);
        $this->assertInstanceOf(Category::class, $aspiration->category);
    }

    /** @test */
    public function aspiration_has_status_and_priority_accessors()
    {
        $aspiration = Aspiration::factory()->create([
            'status' => 'diajukan',
            'priority' => 'tinggi',
        ]);
        $this->assertEquals('bg-yellow-100 text-yellow-800', $aspiration->status_color);
        $this->assertEquals('🟠 Tinggi', $aspiration->priority_label);
    }
}
