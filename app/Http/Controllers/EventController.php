<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Queries\FetchEvents;
use App\Http\Responses\EmptyResponse;
use App\Http\Resources\EventCollection;
use App\Http\Responses\CollectionResponse;

final class EventController
{
    public function __construct(
        private readonly FetchEvents $query
    ) {}

    public function __invoke()
    {
        // No Models Exist = Empty Response
        if (!Event::exists()) {
            return new EmptyResponse();
        }

        // Collection Handling
        $events = $this->query->handle(
            query: Event::query()
        )->get();

        // Collection Handling: Empty Response
        if ($events->isEmpty())
        {
            return new EmptyResponse();
        }

        // Collection Handling: Collection Response
        return new CollectionResponse(
            data: new EventCollection($events),
        );  
    }
}