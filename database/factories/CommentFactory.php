<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Aspiration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'aspiration_id' => Aspiration::factory(),
            'user_id' => User::factory()->siswa(),
            'content' => $this->faker->sentence,
        ];
    }
}
