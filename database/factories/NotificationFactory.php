<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['new_aspiration', 'status_change']),
            'data' => [
                'title' => $this->faker->sentence,
                'new_status' => $this->faker->randomElement(['diajukan', 'diproses', 'selesai', 'ditolak']),
            ],
            'read_at' => null,
        ];
    }
}
