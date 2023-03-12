<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:50'],
            'date' => ['required', 'date'],
            'time' => ['present', 'date_format:H:i', 'nullable'],
            'location' => ['present', 'string', 'min:5', 'max:50', 'nullable'],
            'web_url' => ['present', 'string', 'min:8', 'max:100', 'starts_with:https://', 'nullable']
        ];
    }
}
