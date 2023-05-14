<?php 

namespace App\Http\Controllers\Pilot;

use App\Models\Staffing;
use Illuminate\Http\Request;
use App\Queries\FetchStaffing;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\ModelResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class StaffingController
{
    public function __construct(
        private readonly FetchStaffing $query
    ) {}
    
    public function __invoke(Request $request)
    {
        // ! No Models Exist (Empty Response)
        if (!Staffing::exists()) {
            return new EmptyResponse();
        }

        // ! Date Parameter is Present (Model Response)
        if ($request->has('date')) {
            if (!$request->filled('date')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            try {
                $staffing = $this->query->handle(
                    query: Staffing::query(),
                    date: request('date')
                )->firstOrFail();
            } catch (ModelNotFoundException) {
                $exception = new ModelNotFoundException('Staffing report for ' . request('date') . ' not found.');
                return new ErrorResponse(404, $exception);
            }
    
            return new ModelResponse($staffing);
        }

        // ! Date Parameter is Missing (Model Response)
        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        $staffing = $this->query->handle(
            query: Staffing::query(),
        )->latest('list_date')->get()->first();

        return new ModelResponse($staffing);
    }
}