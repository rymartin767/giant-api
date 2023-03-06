<?php

namespace App\Query;

use Illuminate\Database\Eloquent\Builder;

final class FetchAirlines
{
    public function handle(Builder $query, string $icao = null) : Builder
    {
        if ($icao === null) {
            return $query;
        }

        return $query->where('icao', $icao);
    }
}