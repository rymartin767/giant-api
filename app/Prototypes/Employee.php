<?php

namespace App\Prototypes;

use App\Models\Pilot;
use App\Models\Scale;

final readonly class Employee
{
    public function __construct(
        private readonly Pilot $pilot,
        private readonly array $scales
    ) {}

    public function handle() : array
    {
        return [
            'data' => [
                [
                    'employee_number' => $this->pilot->employee_number,
                    'seniority' => [
                        'seniority_number' => $this->pilot->seniority_number,
                        'doh' => $this->pilot->doh,
                        'seat' => $this->pilot->seat,
                        'fleet' => $this->pilot->fleet,
                        'domicile' => $this->pilot->domicile,
                        'retire' => $this->pilot->retire,
                        'active' => $this->pilot->active,
                        'month' => $this->pilot->month
                    ],
                    'award' => $this->pilot->award->only('employee_number','award_domicile','award_seat','award_fleet'),
                    'scales' => $this->scales
                ]
            ]
        ];
    }
}