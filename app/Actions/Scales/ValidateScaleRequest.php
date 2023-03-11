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
            'year' => 'required',
            'fleet' => 'required',
            'ca_rate' => 'required',
            'fo_rate' => 'required'
        ]);

        return $validator;
    }
}