<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $users;
        $users = $users ?: \App\Models\User::all();

        return [
            'body' => $this->faker->paragraph($this->faker->numberBetween(1, 5)),
            'user_id' => $users->random()->id,
            'created_at' => \Carbon\Carbon::now(),
        ];
    }
}
