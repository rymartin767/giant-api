<?php

namespace App\Http\Requests;

use App\Enums\FlashcardCategory;
use App\Enums\FlashcardEicasType;
use App\Enums\FlashcardReference;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

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
            'answer_image_url' => ['present', 'string', 'nullable'],
            'reference' => [new Enum(FlashcardReference::class)],
            'eicas_type' => [new Enum(FlashcardEicasType::class), 'nullable'],
            'eicas_message' => ['present', 'string', 'nullable'],
        ];
    }
}
