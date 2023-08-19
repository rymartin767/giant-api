<?php

declare(strict_types=1);

namespace App\Http\Controllers\Charts;

use Exception;
use Carbon\Carbon;
use App\Models\Staffing;
use App\Queries\FetchStaffing;
use App\Http\Responses\ChartResponse;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;

final readonly class StaffingChartController
{
    public function __construct(
        private readonly FetchStaffing $query
    ) {}

    public function __invoke()
    {
         // * No Models Exist (Empty Response)
         if (! Staffing::exists()) {
            return new EmptyResponse();
        }
        
        $staffing = $this->query->handle(
            query: Staffing::query()
        )->get(['list_date', 'total_pilot_count']);

        try {
            $collection = $staffing->groupBy(function ($staff) {
                return Carbon::parse($staff['list_date'])->format('M Y'); // keys for chart
            })->map(function($item) {
                return $item[0]['total_pilot_count']; // values for chart
            });
            
            return new ChartResponse($collection->toArray());

        } catch (Exception $e) {
            return new ErrorResponse(404, $e);
        }
    }
}