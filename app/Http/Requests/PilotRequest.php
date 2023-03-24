<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PilotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'seniority_number' => 'required|numeric|digits_between:1,4|min:1|max:2809',
            'employee_number' => 'required|numeric|digits_between:3,6',
            'doh' => 'required|date',
            'seat' => 'required|string|in:CA,FO',
            'fleet' => 'required|string|in:767,747,737,777',
            'domicile' => 'required|string|in:ANC,ALA,CVG,HHN,HNL,HSV,IAH,ICN,JFK,LAX,MEM,MIA,NRT,ONT,ORD,PAE,PDX,SYD,TPA,TPE',
            'retire' => 'required|date',
            'active' => 'boolean',
            'month' => 'required|date'
        ];
    }
}
