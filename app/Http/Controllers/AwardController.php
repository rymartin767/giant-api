<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Queries\FetchAwards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\ModelResponse;
use App\Http\Resources\AwardCollection;
use App\Http\Responses\CollectionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AwardController extends Controller
{
    public function __construct(
        private readonly FetchAwards $query
    ) {}

    public function __invoke(Request $request)
    {
        if ($request->has('employee_number')) {
            if (!$request->filled('employee_number')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request for an empty required parameter.'));
            }

            try {
                $award = $this->query->handle(
                    query: Award::query(),
                    employeeNumber: request('employee_number')
                )->firstOrFail();
            } catch (ModelNotFoundException) {
                $exception = new ModelNotFoundException('Award for employee number ' . request('employee_number') . ' was not found.');
                return new ErrorResponse(404, $exception);
            }
    
            return new ModelResponse($award);
        }

        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        $awards = $this->query->handle(
            query: Award::query(),
        )->get();

        if ($awards->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse(
            data: new AwardCollection($awards)
        );
    }
}