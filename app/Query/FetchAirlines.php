<?php

namespace App\Query;

use Illuminate\Database\Eloquent\Builder;

final class FetchAirlines
{
    public function handle(Builder $query, string $icao = null, bool $scales = null) : Builder
    {
        // Return All Airlines without scales
        if ($icao == null && $scales == null) {
            return $query;
        }

        // Return All Airlines with scales
        if ($icao == null && $scales != null) {
            return $query->with('scales:airline_id,year,fleet,ca_rate,fo_rate');
        }

        // Return specific airline with scales
        if($scales && $icao) {
            return $query->where('icao', $icao)->with('scales:airline_id,year, fleet, ca_rate, fo_rate');
        }

        // Return specific airline without scales
        return $query->where('icao', $icao);
    }
}