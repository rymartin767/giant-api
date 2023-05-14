<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final readonly class FetchStaffing
{
    public function handle(Builder $query, string $date = null) : Builder
    {
        if ($date === null) {
            return $query;
        };

        return $query->where('list_date', $date);
    }
}