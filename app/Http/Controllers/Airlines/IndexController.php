<?php

namespace App\Http\Controllers\Airlines;

use App\Models\Airline;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\CollectionResponse;

class IndexController
{
    public function __invoke()
    {
        $airlines = Airline::query()->get();

        if ($airlines->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse($airlines);
    }
}