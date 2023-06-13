<?php

namespace App\Queries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

final readonly class FetchStaffing
{
    public function handle(Builder $query, string $year = null, string $date = null) : Builder
    {
        if ($year === null && $date === null) {
            return $query;
        };

        if (! $year == null) {
            return $query->whereBetween('list_date', [Carbon::create($year)->startOfYear(), Carbon::create($year)->endOfYear()]);
        }

        return $query->where('list_date', $date);
    }
}