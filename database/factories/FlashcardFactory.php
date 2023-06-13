<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FlashcardFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category' => $this->faker->numberBetween(1, 8),
            'question' => $this->faker->sentence(10, true),
            'answer' => $this->faker->sentence(30, true),
            'question_image_url' => $this->faker->imageUrl(),
            'answer_image_url' => $this->faker->imageUrl(),
            'reference' => 1,
            'eicas_type' => 2,
            'eicas_message' => 'LOW AIRSPEEED'
        ];
    }
}
