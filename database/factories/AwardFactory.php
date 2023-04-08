<?php

namespace Database\Factories;

use App\Models\Pilot;
use Illuminate\Database\Eloquent\Factories\Factory;

class AwardFactory extends Factory
{
    public function definition(): array
    {
        $pilot = Pilot::factory()->create();

        return [
            'base_seniority' => $this->faker->numberBetween(1,30),
            'employee_number' => $pilot->employee_number,
            'domicile' => $pilot->domicile,
            'fleet' => $pilot->fleet,
            'seat' => $pilot->seat,
            'award_domicile' => $pilot->domicile,
            'award_fleet' => $pilot->fleet,
            'award_seat' => $pilot->seat,
            'is_new_hire' => false,
            'is_upgrade' => false,
            'month' => $pilot->month
        ];
    }
}
