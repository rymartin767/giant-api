<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use App\Queries\FetchPilots;
use Illuminate\Http\Request;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\ModelResponse;
use App\Http\Resources\PilotCollection;
use App\Http\Responses\CollectionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class PilotController
{
    public function __construct(
        private readonly FetchPilots $query
    ) {}

    public function __invoke(Request $request)
    {
        // !No Models Exist = Empty Response
        if (!Pilot::exists()) {
            return new EmptyResponse();
        }

        // !Employee Number Parameter is Present (Model Response)
        if ($request->has('employee_number')) {
            if (!$request->filled('employee_number')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            // Model Handling
            try {
                $pilot = $this->query->handle(
                    query: Pilot::query(),
                    employeeNumber: request('employee_number')
                )->orderBy('month', 'desc')->firstOrFail();
            } catch (ModelNotFoundException) {
                $exception = new ModelNotFoundException('Pilot with employee number ' . request('employee_number') . ' was not found.');
                return new ErrorResponse(404, $exception);
            }
    
            // Model Response
            return new ModelResponse($pilot);

        }

        // !Employee Number Parameter is Missing (Collection Response)
            
        // Error Response: Bad Parameter
        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // Collection Handling
        $pilots = $this->query->handle(
            query: Pilot::currentSeniorityList(),
        )->get();

        // Collection Handling: Empty Response
        if ($pilots->isEmpty())
        {
            return new EmptyResponse();
        }

        // Collection Handling: Collection Response
        return new CollectionResponse(
            data: new PilotCollection($pilots)
        );
    }
}