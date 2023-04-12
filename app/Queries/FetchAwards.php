<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final class FetchAwards
{
    public function handle(Builder $query, string $employeeNumber = null, string $code = null) : Builder
    {
        // Return All Awards
        if ($employeeNumber == null && $code == null) {
            return $query;
        }

        // Return Awards for Domicile
        if ($employeeNumber == null && $code != null) {
            return $query
                ->where('award_domicile', $code);
        }

        // Return Award for Employee
        return $query
            ->where('employee_number', $employeeNumber);
    }
}