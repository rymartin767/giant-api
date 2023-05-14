<?php

namespace App\Actions\Awards;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

final class ValidateAwardRequest
{
    public function __construct(protected Request $request) {}

    public function handle() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'base_seniority' => 'required|numeric|digits_between:1,3|min:1',
            'employee_number' => 'required|numeric|digits_between:3,6',
            'domicile' => 'required|string|in:ANC,ALA,CVG,HHN,HNL,HSV,IAH,ICN,JFK,LAX,MEM,MIA,NRT,ONT,ORD,PAE,PDX,SYD,TPA,TPE',
            'fleet' => 'required|string|in:767,747,737,777',
            'seat' => 'required|string|in:CA,FO',
            'award_domicile' => 'required|string|in:ANC,ALA,CVG,HHN,HNL,HSV,IAH,ICN,JFK,LAX,MEM,MIA,NRT,ONT,ORD,PAE,PDX,SYD,TPA,TPE',
            'award_fleet' => 'required|string|in:767,747,737,777',
            'award_seat' => 'required|string|in:CA,FO',
            'is_new_hire' => 'boolean',
            'is_upgrade' => 'boolean',
            'month' => 'required|date'
        ]);

        return $validator;
    }
}