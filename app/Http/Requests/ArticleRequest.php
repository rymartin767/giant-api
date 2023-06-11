<?php

namespace App\Http\Requests;

use App\Enums\ArticleCategory;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'category' => [new Enum(ArticleCategory::class)],
            'date' => ['required', 'date'],
            'title' => ['required', 'string', 'min:12', 'max:100'],
            'author' => ['required', 'string', 'min:5', 'max:100'],
            'story' => ['required', 'string', 'min:50', 'max:10000'],
            'web_url' => ['present', 'url'],
            'slug' => ['present', 'nullable']
        ];
    }
}
