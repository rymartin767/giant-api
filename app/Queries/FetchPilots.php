<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final class FetchPilots
{
    public function handle(Builder $query, string $employeeNumber = null) : Builder
    {
        // Return the most recent seniority list of pilots
        if ($employeeNumber == null) {
            return $query->select(['seniority_number', 'employee_number', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'active', 'month']);
        }

        return $query->select(['seniority_number', 'employee_number', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'active', 'month'])
            ->where('employee_number', $employeeNumber);
    }
}