<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->slug,
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence(10),
            'body' => $this->faker->paragraphs($this->faker->numberBetween(1, 3), true),
            'created_at' => \Carbon\Carbon::now(),

        ];
    }
}
