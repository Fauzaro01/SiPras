<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => 'siswa',
            'nis' => fake()->unique()->numerify('######'),
            'kelas' => fake()->randomElement(['X-1', 'X-2', 'X-3', 'XI-1', 'XI-2', 'XII-1']),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * State for admin users.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'username' => fake()->unique()->userName(),
            'nis' => null,
            'kelas' => null,
        ]);
    }

    /**
     * State for siswa users.
     */
    public function siswa(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'siswa',
            'nis' => fake()->unique()->numerify('######'),
            'kelas' => fake()->randomElement(['X-1', 'X-2', 'X-3', 'XI-1', 'XI-2', 'XII-1']),
        ]);
    }
}
