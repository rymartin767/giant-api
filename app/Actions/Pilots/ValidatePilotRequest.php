<?php

namespace App\Actions\Pilots;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

final class ValidatePilotRequest
{
    public function __construct(protected Request $request) {}

    public function handle() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'seniority_number' => 'required|numeric|digits_between:1,4',
            'employee_number' => 'required|numeric|digits_between:3,6',
            'doh' => 'required|date',
            'seat' => 'required|string|in:CA,FO',
            'fleet' => 'required|string|in:767,747,737,777',
            'domicile' => 'required|string|in:ANC,ALA,CVG,HHN,HNL,HSV,IAH,ICN,JFK,LAX,MEM,MIA,NRT,ONT,ORD,PAE,PDX,SYD,TPA,TPE',
            'retire' => 'required|date',
            'active' => 'boolean',
            'month' => 'required|date'
        ]);

        return $validator;
    }
}