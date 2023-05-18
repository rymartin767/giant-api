<?php

namespace App\Actions\Scales;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

final class ValidateScaleRequest
{
    public function __construct(public Request $request) {}

    public function handle() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'year' => ['required', 'integer', 'min:1', 'max:15'],
            'fleet' => ['required', 'string', 'starts_with:A,B,M'],
            'ca_rate' => ['required', 'integer'],
            'fo_rate' => ['required', 'integer']
        ]);

        return $validator;
    }
}