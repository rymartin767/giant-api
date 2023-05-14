<?php

namespace App\Actions\Pilots;

use Carbon\Carbon;
use Illuminate\Http\Request;

final class GeneratePilotRequest
{
    public function __construct(protected array $pilot, public string $month) {}

    public function handle() : Request
    {
        $request = new Request([
            'seniority_number' => $this->pilot[0],
            'employee_number' => $this->pilot[1],
            'doh' => Carbon::parse($this->pilot[2]), // MM/DD/YY
            'seat' => $this->pilot[3],
            'domicile' => $this->pilot[4],
            'fleet' => $this->pilot[5],
            'status' => constant("\App\Enums\PilotStatus::{$this->pilot[6]}")->value, //The constant() function can return the value of a constant using a string variable.
            'retire' => Carbon::parse($this->pilot[7]), // MM/DD/YY
            'month' => $this->month
        ]);

        return $request;
    }
}