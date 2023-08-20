<?php

namespace App\Actions\Scales;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class MakeScaleRequest
{
    public function __construct(public Collection $collection) {}

    public function handle() : Request
    {
        $request = new Request([
            'airline_id' => intval($this->collection['airline_id']),
            'year' => intval($this->collection[0]),
            'fleet' => $this->collection[1],
            'ca_rate' => floatval($this->collection[2]),
            'fo_rate' => floatval($this->collection[3]),
        ]);

        return $request;
    }
}