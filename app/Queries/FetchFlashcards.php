<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final class FetchFlashcards
{
    public function handle(Builder $query, int $category) : Builder
    {
        if ($category == 0) {
            return $query;
        }
        
        return $query->where('category', $category);
    }
}