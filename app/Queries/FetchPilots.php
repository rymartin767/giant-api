<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final readonly class FetchPilots
{
    public function handle(Builder $query, string $employeeNumber = null) : Builder
    {
        // Return the most recent seniority list of pilots
        if ($employeeNumber == null) {
            return $query;
        }

        return $query
            ->where('employee_number', $employeeNumber)
            ->with('award:employee_number,award_domicile,award_seat,award_fleet');
    }
}