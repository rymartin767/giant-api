<?php

namespace App\Http\Controllers\Airlines;

use App\Models\Airline;
use Illuminate\Http\Request;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\ModelResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Show
{
    public function __invoke(Request $request)
    {
        if ($request->missing('icao') || !$request->filled('icao')) {
            $exception = new BadRequestException('Please check your request parameters.');
            return new ErrorResponse(401, $exception);
        }

        try {
            $airline = Airline::query()->where('icao', request('icao'))->firstOrFail();
        } catch (ModelNotFoundException) {
            $exception = new ModelNotFoundException('Airline with ICAO code ' . request('icao') . ' not found.');
            return new ErrorResponse(404, $exception);
        }

        return new ModelResponse($airline);
    }
}