<?php

namespace App\Actions\Pilots;

use App\Enums\PilotStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
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
            'domicile' => 'required|string|in:ANC,ALA,CVG,HHN,HKG,HNL,HSV,IAH,ICN,JFK,LAX,LEJ,LGG,MEM,MIA,NRT,ONT,ORD,PAE,PDX,SYD,TPA,TPE,ZAZ',
            'retire' => 'required|date',
            'status' => [new Enum(PilotStatus::class)],
            'month' => 'required|date'
        ]);

        return $validator;
    }
}