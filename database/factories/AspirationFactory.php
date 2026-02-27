<?php

namespace Database\Factories;

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aspiration>
 */
class AspirationFactory extends Factory
{
    protected $model = Aspiration::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory()->siswa(),
            'category_id' => Category::factory(),
            'judul'       => fake()->sentence(5),
            'deskripsi'   => fake()->paragraph(),
            'lokasi'      => 'Gedung ' . fake()->randomLetter() . ' Lantai ' . fake()->numberBetween(1, 3),
            'status'      => 'diajukan',
            'bukti_foto'  => null,
        ];
    }

    public function diajukan(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'diajukan']);
    }

    public function diproses(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'diproses']);
    }

    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'selesai']);
    }

    public function ditolak(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'ditolak']);
    }
}
