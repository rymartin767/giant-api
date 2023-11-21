<?php

namespace App\Actions\Pilots;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

final class ValidateStaffingRequest
{
    public function __construct(protected Request $request) {}

    public function handle() : ValidationValidator
    {
        $validator = Validator::make($this->request->all(), [
            'list_date' => 'required|date',
            'total_pilot_count' => 'required|integer|max:3000',
            'active_pilot_count' => 'required|integer|max:3000',
            'inactive_pilot_count' => 'required|integer',
            'net_gain_loss' => 'required|integer',
            'ytd_gain_loss' => 'required|integer',
            'average_age' => 'required|integer'
        ]);

        return $validator;
    }
}