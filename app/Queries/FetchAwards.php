<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final class FetchAwards
{
    public function handle(Builder $query, string $employeeNumber = null) : Builder
    {
        if ($employeeNumber == null) {
            return $query->select(['base_seniority', 'employee_number', 'domicile', 'fleet', 'seat', 'award_domicile', 'award_fleet', 'award_seat', 'is_upgrade', 'month']);
        }

        return $query->select(['base_seniority', 'employee_number', 'domicile', 'fleet', 'seat', 'award_domicile', 'award_fleet', 'award_seat', 'is_upgrade', 'month'])
            ->where('employee_number', $employeeNumber);
    }
}