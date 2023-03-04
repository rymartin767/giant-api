<?php

namespace App\Http\Controllers\Events;

use App\Models\Event;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\CollectionResponse;

class IndexController
{
    public function __invoke()
    {
        $events = Event::query()->get(['id', 'title', 'date', 'time', 'location', 'image_url', 'web_url']);

        if ($events->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse($events);
    }
}