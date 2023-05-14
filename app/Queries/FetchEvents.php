<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

final class FetchEvents
{
    public function handle(Builder $query) : Builder
    {
        return $query->select(['id', 'title', 'date', 'time', 'location', 'image_url', 'web_url']);
    }
}