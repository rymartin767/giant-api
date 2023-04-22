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
    ) {
    }

    public function __invoke(Request $request)
    {
        // ! Empty Response
        if (!Award::exists()) {
            return new EmptyResponse();
        }

        // ! Error Responses
        // Both Optional Parameters Present
        if ($request->has('employee_number') && $request->has('domicile')) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // Both Optional Parameters Missing
        if (
            $request->collect()->isNotEmpty() &&
            $request->missing('employee_number') &&
            $request->missing('domicile')
        ) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

         // Optional Parameter Present but Empty
        if (
            $request->collect()->isNotEmpty() &&
            $request->has('employee_number') &&
            ! $request->filled('employee_number')
        ) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        if (
            $request->collect()->isNotEmpty() &&
            $request->has('domicile') &&
            ! $request->filled('domicile')
        ) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // ! Collection Response: No Parameters
        if ($request->collect()->isEmpty()) {
            // Collection Handling
            $awards = $this->query->handle(
                query: Award::query(),
            )->get();

            // Empty Response if collection is empty
            if ($awards->isEmpty()) {
                return new EmptyResponse();
            }

            // Collection Response
            return new CollectionResponse(
                data: new AwardCollection($awards)
            );
        }

        // ! Collection Response: parameter> domicile
        if ($request->has('domicile')) {
            $awards = $this->query->handle(
                query: Award::query(),
                employeeNumber: null,
                domicile: request('domicile')
            )->get();

            return new CollectionResponse(
                data: new AwardCollection($awards)
            );
        }

        // ! Model Response: parameter> employee_number
        if ($request->has('employee_number')) {

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
    }
}
