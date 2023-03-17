<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category' => 1,
            'date' => $this->faker->date('Y-m-d', 'now'),
            'title' => $this->faker->sentence(12, true),
            'author' => $this->faker->name(),
            'story' => $this->faker->paragraph(2, true),
            'web_url' => $this->faker->url(),
            'slug' => null
        ];
    }
}
