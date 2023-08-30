<?php

namespace App\Http\Controllers;

use App\Models\Scale;
use Illuminate\Support\Str;
use App\Queries\FetchScales;
use Illuminate\Http\Request;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Resources\ScaleCollection;
use App\Http\Responses\CollectionResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class ScaleController
{
    public function __construct(
        private readonly FetchScales $query
    ) {
    }

    public function __invoke(Request $request)
    {
        // No Models Exist = Empty Response
        if (! Scale::exists()) {
            return new EmptyResponse();
        }

        if ($request->missing('icao')) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        if ($request->has('icao')) {
            if (! $request->filled('icao')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            // ! MULTIPLE ICAO VALUES
            if (Str::of($request->input('icao'))->contains(',')) {

                $collection = collect();

                $icao_one = Str::of($request->input('icao'))->before(',')->value();
                $icao_two = Str::of($request->input('icao'))->after(',')->value();

                $scales = $this->query->handle(
                    query: Scale::query(),
                    icao: $icao_one
                )->get(['year', 'fleet', 'ca_rate', 'fo_rate']);

                $collection->put($icao_one, $scales);

                $scales = $this->query->handle(
                    query: Scale::query(),
                    icao: $icao_two
                )->get(['year', 'fleet', 'ca_rate', 'fo_rate']);

                $collection->put($icao_two, $scales);

                return new CollectionResponse(
                    data: new ScaleCollection($collection),
                );
            }

            // Collection Handling
            $scales = $this->query->handle(
                query: Scale::query(),
                icao: request('icao')
            )->get(['year', 'fleet', 'ca_rate', 'fo_rate']);

            // Collection Handling: Empty Response
            if ($scales->isEmpty()) {
                return new EmptyResponse();
            }

            // Collection Handling: Collection Response
            return new CollectionResponse(
                data: new ScaleCollection($scales),
            );
        }
    }
}
