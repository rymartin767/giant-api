<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

class FetchFlashcards
{
    public function handle(Builder $query, int $category = null, int $reference = null) : Builder
    {
        if ($category === null && $reference === null) {
            return $query;
        }
        
        if ($category !== null) {
            return $query->where('category', $category);
        }

        return $query->where('reference', $reference);
    }
}