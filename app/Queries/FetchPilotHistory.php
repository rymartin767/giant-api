<?php

namespace App\Queries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

final readonly class FetchPilotHistory
{
    public function handle(Builder $query, string $employeeNumber, string $year = null) : Builder
    {
        if ($year == null) {
            return $query
                ->select('seniority_number', 'employee_number', 'seat', 'fleet', 'domicile', 'month')
                ->where('employee_number', $employeeNumber)
                ->whereBetween('month', [Carbon::today()->startOfYear(), Carbon::today()->endOfYear()])
                ->orderBy('month');
        }

        $begin = Carbon::create($year)->startOfYear();
        $end = Carbon::create($year)->endOfYear();

        return $query
                ->select('seniority_number', 'employee_number', 'seat', 'fleet', 'domicile', 'month')
                ->where('employee_number', $employeeNumber)
                ->whereBetween('month', [$begin, $end])
                ->orderBy('month');
    }
}