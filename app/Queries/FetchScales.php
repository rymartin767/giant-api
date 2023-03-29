<?php

namespace App\Queries;

use App\Models\Airline;
use Illuminate\Database\Eloquent\Builder;

final class FetchScales
{
    public function handle(Builder $query, string $fleet) : Builder
    {
        $id = Airline::where('icao', 'GTI')->sole()->id;

        return $query
            ->where('airline_id', $id)
            ->where('fleet', $fleet);
    }
}