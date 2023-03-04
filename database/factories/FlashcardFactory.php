<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flashcard>
 */
class FlashcardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->numberBetween(1, 8),
            'question' => $this->faker->sentence(10, true),
            'answer' => $this->faker->sentence(30, true),
            'question_image_url' => $this->faker->imageUrl(),
            'answer_image_url' => $this->faker->imageUrl(),
        ];
    }
}
