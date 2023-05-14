<?php

namespace Database\Seeders;

use App\Models\Scale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AirlineScalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scales = [
            [
                'airline_id' => 1,
                'year' => 1,
                'fleet' => 737,
                'ca_rate' => 200.10,
                'fo_rate' => 100.10
            ],
            [
                'airline_id' => 1,
                'year' => 2,
                'fleet' => 737,
                'ca_rate' => 220.20,
                'fo_rate' => 110.20
            ],
            [
                'airline_id' => 1,
                'year' => 3,
                'fleet' => 737,
                'ca_rate' => 230.30,
                'fo_rate' => 130.30
            ],
            [
                'airline_id' => 1,
                'year' => 4,
                'fleet' => 737,
                'ca_rate' => 240.40,
                'fo_rate' => 140.40
            ],
            [
                'airline_id' => 1,
                'year' => 5,
                'fleet' => 737,
                'ca_rate' => 250.50,
                'fo_rate' => 150.50
            ],
            [
                'airline_id' => 1,
                'year' => 6,
                'fleet' => 737,
                'ca_rate' => 260.60,
                'fo_rate' => 160.60
            ],
            [
                'airline_id' => 1,
                'year' => 7,
                'fleet' => 737,
                'ca_rate' => 270.70,
                'fo_rate' => 170.70
            ],
            [
                'airline_id' => 1,
                'year' => 8,
                'fleet' => 737,
                'ca_rate' => 280.80,
                'fo_rate' => 180.80
            ],
            [
                'airline_id' => 1,
                'year' => 9,
                'fleet' => 737,
                'ca_rate' => 290.90,
                'fo_rate' => 190.90
            ],
            [
                'airline_id' => 1,
                'year' => 10,
                'fleet' => 737,
                'ca_rate' => 300.00,
                'fo_rate' => 200.00
            ],
            [
                'airline_id' => 1,
                'year' => 11,
                'fleet' => 737,
                'ca_rate' => 310.10,
                'fo_rate' => 210.10
            ],
            [
                'airline_id' => 1,
                'year' => 12,
                'fleet' => 737,
                'ca_rate' => 320.20,
                'fo_rate' => 220.20
            ],
        ];

        foreach ($scales as $scale) {
            Scale::create([
                'airline_id' => $scale['airline_id'],
                'year' => $scale['year'],
                'fleet' => $scale['fleet'],
                'ca_rate' => $scale['ca_rate'],
                'fo_rate' => $scale['fo_rate'],
            ]);
        }
    }
}
