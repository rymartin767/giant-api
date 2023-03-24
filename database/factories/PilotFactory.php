<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pilot>
 */
class PilotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'seniority_number' => $this->faker->numberBetween(1,10),
            'employee_number' => $this->faker->numberBetween(224,234),
            'doh' => $this->faker->dateTimeBetween('-20 years', 'now'),
            'seat' => 'CA',
            'fleet' => '747',
            'domicile' => 'ORD',
            'retire' => $this->faker->dateTimeBetween('+6 months', '+25 years'),
            'active' => true,
            'month' => Carbon::parse('03/10/2023')
        ];
    }
}
