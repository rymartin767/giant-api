<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => 'Event Factory Test',
            'date' => $this->faker->date(),
            'time' => $this->faker->time('H:i'),
            'location' => 'Columbus, OH',
            'image_url' => 'images/events/test-image.webp',
            'web_url' => $this->faker->url()
        ];
    }
}
