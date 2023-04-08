<?php

namespace App\Actions\Awards;

use Illuminate\Http\Request;

final class CreateAwardRequest
{
    public function __construct(protected array $award, public string $month) {}

    public function handle() : Request
    {
        $request = new Request([
            'base_seniority' => $this->award[0],
            'employee_number' => $this->award[1],
            'is_new_hire' => $this->award[2] == 'NH',
            'domicile' => $this->award[3],
            'fleet' => $this->award[4],
            'seat' => $this->award[5],
            'award_domicile' => $this->award[6],
            'award_fleet' => $this->award[7],
            'award_seat' => $this->award[8],
            'is_upgrade' => $this->award[5] == 'FO' && $this->award[8] == 'CA' && end($this->award) != 'Phantom',
            'month' => $this->month
        ]);

        return $request;
    }
}