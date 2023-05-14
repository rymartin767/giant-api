<?php

namespace Database\Factories;

use App\Models\Airline;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scale>
 */
class ScaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airline_id' => Airline::factory(),
            'year' => 1,
            'fleet' => 737,
            'ca_rate' => 100.10,
            'fo_rate' => 50.20
        ];
    }
}
