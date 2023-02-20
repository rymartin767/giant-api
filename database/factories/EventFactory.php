<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
