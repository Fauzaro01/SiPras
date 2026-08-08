<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\Aspiration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'aspiration_id' => Aspiration::factory(),
            'user_id' => User::factory()->admin(), // feedback from admin
            'pesan' => $this->faker->paragraph,
            'parent_id' => null,
        ];
    }

    /**
     * State for a reply from a siswa.
     */
    public function reply(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory()->siswa(),
        ]);
    }
}
