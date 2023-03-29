<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;
use App\Queries\FetchAirlines;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\ModelResponse;
use App\Http\Resources\AirlineCollection;
use App\Http\Responses\CollectionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class AirlineController
{
    public function __construct(
        private readonly FetchAirlines $query
    ) {}

    public function __invoke(Request $request)
    {
        if ($request->missing('icao') || !$request->filled('icao')) {

            if ($request->collect()->isNotEmpty() && $request->missing('scales')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            $airlines = $this->query->handle(
                query: Airline::query(),
                icao: null,
                scales: $request->has('scales')
            )->get();

            if ($airlines->isEmpty())
            {
                return new EmptyResponse();
            }

            return new CollectionResponse(
                data: new AirlineCollection($airlines)
            );
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