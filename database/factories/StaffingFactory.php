<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Pilot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staffing>
 */
class StaffingFactory extends Factory
{
    public function definition(): array
    {
        $month = Pilot::pluck('month')->sortDesc()->unique()->first();

        return [
            'list_date' => $month,
            'total_pilot_count' => 2800,
            'active_pilot_count' => 2693,
            'inactive_pilot_count' => 107,
            'net_gain_loss' => -14,
            'ytd_gain_loss' => -31,
            'average_age' => 45,
        ];
    }
}
