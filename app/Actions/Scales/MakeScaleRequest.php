<?php

namespace App\Actions\Scales;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class MakeScaleRequest
{
    public function __invoke(Collection $collection) : Request
    {
        $request = new Request([
            'year' => $collection[0],
            'fleet' => $collection[1],
            'ca_rate' => $collection[2],
            'fo_rate' => $collection[3],
        ]);

        return $request;
    }
}