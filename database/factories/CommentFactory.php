<?php

namespace Database\Factories;

use App\Models\Aspiration;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
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
