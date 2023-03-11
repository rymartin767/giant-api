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
            'year' => $this->collection[0],
            'fleet' => $this->collection[1],
            'ca_rate' => $this->collection[2],
            'fo_rate' => $this->collection[3],
        ]);

        return $request;
    }
}