<?php

namespace App\Http\Requests;

use App\Enums\AirlineSector;
use App\Enums\AirlineUnion;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class AirlineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'sector' => [new Enum(AirlineSector::class)],
            'name' => ['required', 'string', 'min:8', 'max:35'],
            'icao' => ['required', 'string', 'size:3'],
            'iata' => ['required', 'string', 'size:2'],
            'union' => [new Enum(AirlineUnion::class)],
            'pilot_count' => ['required', 'integer', 'max:17000'],
            'is_hiring' => ['required', 'boolean'],
            'web_url' => ['required', 'string', 'starts_with:https://'],
            'slug' => []
        ];
    }
}
