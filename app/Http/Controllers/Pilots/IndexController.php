<?php

namespace App\Http\Controllers\Pilots;

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

class IndexController
{
    public function __construct(
        private readonly FetchPilots $query
    ) {}

    public function __invoke(Request $request)
    {
        if ($request->has('employee_number')) {
            try {
                $pilot = $this->query->handle(
                    query: Pilot::query(),
                    employeeNumber: request('employee_number')
                )->orderBy('month', 'desc')->firstOrFail();
            } catch (ModelNotFoundException) {
                $exception = new ModelNotFoundException('Pilot with employee number ' . request('employee_number') . ' was not found.');
                return new ErrorResponse(404, $exception);
            }
    
            return new ModelResponse($pilot);
        }

        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        $pilots = $this->query->handle(
            query: Pilot::currentSeniorityList(),
        )->get();

        if ($pilots->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse(
            data: new PilotCollection($pilots)
        );
        
    }
}