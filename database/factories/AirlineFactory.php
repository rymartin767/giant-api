<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airline>
 */
class AirlineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sector' => $this->faker->numberBetween(1,5),
            'name' => $this->faker->firstName() . ' Airlines', 
            'icao' => $this->faker->randomLetter() . $this->faker->randomLetter() . $this->faker->randomLetter(), 
            'iata' => $this->faker->randomLetter() . $this->faker->randomLetter(),
            'union' => $this->faker->numberBetween(1,3),
            'pilot_count' => 2000, 
            'is_hiring' => $this->faker->boolean(50),
            'web_url' => 'https:://giantpilots.com',
            'slug' => null
        ];
    }
}
