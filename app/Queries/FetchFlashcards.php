<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

class FetchFlashcards
{
    public function handle(Builder $query, int $category = null) : Builder
    {
        if ($category === null) {
            return $query;
        }
        
        return $query->where('category', $category);
    }
}