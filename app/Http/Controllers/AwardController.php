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
        // !No Models Exist = Empty Response
        if (!Award::exists()) {
            return new EmptyResponse();
        }

        // !Employee Number Parameter Present (Model Response)
        if ($request->has('employee_number')) {

            // Empty Parameter
            if (!$request->filled('employee_number')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request for an empty required parameter.'));
            }

            // Model Handling: ModelNotFound Error Response
            try {
                $award = $this->query->handle(
                    query: Award::query(),
                    employeeNumber: request('employee_number')
                )->firstOrFail();
            } catch (ModelNotFoundException) {
                $exception = new ModelNotFoundException('Award for employee number ' . request('employee_number') . ' was not found.');
                return new ErrorResponse(404, $exception);
            }

            // Model Handling: Model Response
            return new ModelResponse($award);
        }

        // !Employee Number Parameter Missing (Collection Response)

        // Bad Parameter name
        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // Collection Handling
        $awards = $this->query->handle(
            query: Award::query(),
        )->get();

        // Empty Response if collection is empty
        if ($awards->isEmpty())
        {
            return new EmptyResponse();
        }

        // Collection Response
        return new CollectionResponse(
            data: new AwardCollection($awards)
        );
    }
}