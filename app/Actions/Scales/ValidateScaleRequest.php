<?php

namespace App\Actions\Scales;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

final class ValidateScaleRequest
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:1|max:15',
            'fleet' => 'required|string',
            'ca_rate' => ['required', 'numeric', 'min:100', 'max:515'],
            'fo_rate' => ['required', 'numeric', 'min:50', 'max:315'],
        ]);

        return $validator;
    }
}