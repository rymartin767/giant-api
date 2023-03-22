<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final class FetchFlashcards
{
    public function handle(Builder $query, int $category) : Builder
    {
        if ($category == 0) {
            return $query->select(['category', 'question', 'answer', 'question_image_url', 'answer_image_url']);
        }
        
        return $query->select(['category', 'question', 'answer', 'question_image_url', 'answer_image_url'])->where('category', $category);
    }
}