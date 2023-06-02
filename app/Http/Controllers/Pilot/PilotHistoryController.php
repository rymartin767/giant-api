<?php

namespace App\Http\Controllers\Pilot;

use App\Models\Pilot;
use App\Models\Staffing;
use Illuminate\Http\Request;
use App\Queries\FetchStaffing;
use App\Queries\FetchPilotHistory;
use App\Http\Responses\ErrorResponse;
use App\Http\Resources\PilotCollection;
use App\Http\Responses\CollectionResponse;
use App\Http\Responses\EmptyResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class PilotHistoryController
{
    public function __construct(
        private readonly FetchPilotHistory $queryPilots,
        private readonly FetchStaffing $queryStaffing
    ) {}

    public function __invoke(Request $request)
    {
        if ($request->missing('employee_number') || ! $request->filled('employee_number')) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        $history = $this->queryPilots->handle(
            query: Pilot::query(),
            employeeNumber: request('employee_number'),
            year: request('year') ?? null
        )->get();

        if ($history->isEmpty()) {
            return new EmptyResponse();
        }

        $history->map(function($pilot) {
            $totalPilots = $this->queryStaffing->handle(
                query: Staffing::query(),
                date: $pilot->month->format('Y-m-d')
            )->get()->first()->total_pilot_count;

            $pilot['aaww_total_pilots'] = $totalPilots;
            $pilot['employee_aaww_seniority_percentage'] = ceil(round(($pilot->seniority_number / $totalPilots) * 100, 1, PHP_ROUND_HALF_DOWN));
        });

        return new CollectionResponse(
            data: new PilotCollection($history)
        );

    }
}