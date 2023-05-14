<?php 

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final class FetchArticles
{
    public function handle(Builder $query, int $id = null) : Builder
    {
        if ($id !== null) {
            return $query
                ->select(['id', 'category', 'date', 'title', 'author', 'story', 'web_url', 'slug'])
                ->where('id', $id);
        }

        return $query->select(['id', 'category', 'date', 'title', 'author', 'story', 'web_url', 'slug']);
    }
}