<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final class FetchAwards
{
    public function handle(Builder $query, string $employeeNumber = null, string $domicile = null) : Builder
    {
        // Return All Awards
        if ($employeeNumber == null && $domicile == null) {
            return $query;
        }

        // Return Awards for Domicile
        if ($employeeNumber == null && $domicile != null) {
            return $query
                ->where('award_domicile', $domicile);
        }

        // Return Award for Employee
        return $query
            ->where('employee_number', intval($employeeNumber));
    }
}