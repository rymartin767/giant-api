<?php

namespace App\Http\Requests;

use App\Enums\FlashcardCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class FlashcardRequest extends FormRequest
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
            'category' => [new Enum(FlashcardCategory::class)],
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
            'question_image_url' => ['present', 'string', 'nullable'],
            'answer_image_url' => ['present', 'string', 'nullable']
        ];
    }
}
