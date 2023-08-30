<?php

namespace App\Queries;

use App\Models\Airline;
use Illuminate\Database\Eloquent\Builder;

final class FetchScales
{
    public function handle(Builder $query, string $icao, string $fleet = null) : Builder
    {
        $id = Airline::where('icao', $icao)->sole()->id;

        if ($fleet !== null) {
            return $query
                ->where('airline_id', $id)
                ->where('fleet', 'B' . $fleet);
        }

        return $query->where('airline_id', $id);
    }
}