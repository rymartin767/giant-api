<?php 

namespace App\Http\Controllers\Staffing;

use App\Models\Staffing;
use Illuminate\Http\Request;
use App\Queries\FetchStaffing;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\ModelResponse;
use App\Http\Resources\StaffingCollection;
use App\Http\Responses\CollectionResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class StaffingController
{
    public function __construct(
        private readonly FetchStaffing $query
    ) {}
    
    public function __invoke(Request $request)
    {
        // * No Models Exist (Empty Response)
        if (! Staffing::exists()) {
            return new EmptyResponse();
        }

        //  * Return a collection for a specific year
        if ($request->has('year')) {
            if (! $request->filled('year')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            $reports = $this->query->handle(
                query: Staffing::query(),
            )->latest()->limit(12)->get();

            if ($reports->isEmpty()) {
                return new EmptyResponse();
            }

            return new CollectionResponse(
                data: new StaffingCollection($reports)
            );
        }

        //  * Return a collection of the last 12 months
        if ($request->has('latest')) {
            if (! $request->filled('latest')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            $reports = $this->query->handle(
                query: Staffing::query(),
                year: request('year'),
                date: null
            )->get();

            if ($reports->isEmpty()) {
                return new EmptyResponse();
            }

            return new CollectionResponse(
                data: new StaffingCollection($reports)
            );
        }

        // Bad Parameter Name
        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // Model Response for most recent staffing report
        $staffing = $this->query->handle(
            query: Staffing::query(),
        )->latest('list_date')->get()->first();

        return new ModelResponse($staffing);
    }
}