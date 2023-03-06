<?php

namespace App\Http\Controllers\Airlines;

use App\Models\Airline;
use App\Query\FetchAirlines;
use Illuminate\Http\Request;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\ModelResponse;
use App\Http\Responses\CollectionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class IndexController
{
    public function __construct(
        private readonly FetchAirlines $query
    ) {}

    public function __invoke(Request $request)
    {
        if ($request->missing('icao') || !$request->filled('icao')) {

            if ($request->collect()->isNotEmpty()) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            $airlines = $this->query->handle(
                query: Airline::query()
            )->get();

            if ($airlines->isEmpty())
            {
                return new EmptyResponse();
            }

            return new CollectionResponse($airlines);
        }

        try {
            $airline = $this->query->handle(
                query: Airline::query(),
                icao: request('icao')
            )->firstOrFail();
        } catch (ModelNotFoundException) {
            $exception = new ModelNotFoundException('Airline with ICAO code ' . request('icao') . ' not found.');
            return new ErrorResponse(404, $exception);
        }

        return new ModelResponse($airline);
    }
}