<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PilotFactory extends Factory
{
    public function definition(): array
    {
        $month = now()->subMonth()->startOfMonth()->addDays(14);
        $doh = $this->faker->dateTimeBetween('-15 years', '-6 months');
        $retire = $this->faker->dateTimeBetween('now', '25 years');

        return [
            'seniority_number' => $this->faker->numberBetween(1,3000),
            'employee_number' => intval($this->faker->numberBetween(450, 458) . $this->faker->numberBetween(001, 999)),
            'doh' => Carbon::parse($doh), // mimic the CreatePilotRequest
            'seat' => 'CA',
            'fleet' => '747',
            'domicile' => 'ORD',
            'retire' => Carbon::parse($retire), // mimic the CreatePilotRequest
            'status' => 1,
            'month' => Carbon::parse($month)->format('Y-m-d') // mimic the CreatePilotRequest and mysql format mm/dd/YYYY
        ];
    }
}
