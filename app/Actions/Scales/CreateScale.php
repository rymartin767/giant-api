<?php

namespace App\Actions\Scales;

use App\Models\Scale;
use Illuminate\Support\Facades\Validator;

final class CreateScale
{
    public function __invoke(Validator $validated) : void
    {
        Scale::create([
            'year' => $validated->$validated->year,
            'fleet' => $validated->$validated->fleet,
            'ca_rate' => $validated->$validated->ca_rate,
            'fo_rate' => $validated->$validated->fo_rate
        ]);
    }
}