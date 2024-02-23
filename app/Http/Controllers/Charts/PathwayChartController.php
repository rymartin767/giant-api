<?php

declare(strict_types=1);

namespace App\Http\Controllers\Charts;

use Exception;
use Carbon\Carbon;
use App\Models\Pilot;
use App\Models\Staffing;
use App\Queries\FetchPilots;
use App\Http\Responses\ChartResponse;
use App\Http\Responses\ErrorResponse;

final readonly class PathwayChartController
{
    public function __construct(
        private readonly FetchPilots $query
    ) {}

    public function __invoke()
    {
        $begin = Carbon::today()->startOfYear();
        $end = Carbon::today()->endOfYear();

        $employee = $this->query->handle(
            query: Pilot::query()->select('seniority_number', 'employee_number', 'month')->where('employee_number', request('employee_number'))
        )->get();

        $history = $employee->whereBetween('month', [$begin, $end])->sortBy('month');

        $history->map(function($h) {
            $count = Staffing::where('list_date', $h['month'])->sole()->total_pilot_count;
            $relative = ceil(round(($h['seniority_number'] / $count) * 100, 1, PHP_ROUND_HALF_DOWN));
            $h['employee-sen'] = $relative;

            try {
                $junior_737 = Pilot::juniorCaptainByFleet('737', $h['month']);
                $relative_three = ceil(round(($junior_737->sen / $count) * 100, 1, PHP_ROUND_HALF_DOWN));
                $h['737-captain-sen'] = $relative_three;

            } catch(Exception $e) {
                $h['737-captain-sen'] = 99;
            }

            try {
                $junior_747 = Pilot::juniorCaptainByFleet('747', $h['month']);
                $relative_four = ceil(round(($junior_747->sen / $count) * 100, 1, PHP_ROUND_HALF_DOWN));
                $h['747-captain-sen'] = $relative_four;
            } catch(Exception $e) {
                $h['747-captain-sen'] = 99;
            }

            try {
                $junior_767 = Pilot::juniorCaptainByFleet('767', $h['month']);
                $relative_six = ceil(round(($junior_767->sen / $count) * 100, 1, PHP_ROUND_HALF_DOWN));
                $h['767-captain-sen'] = $relative_six;
            } catch(Exception $e) {
                $h['767-captain-sen'] = 99;
            }

            try {
                $junior_777 = Pilot::juniorCaptainByFleet('777', $h['month']);
                $relative_seven = ceil(round(($junior_777->sen / $count) * 100, 1, PHP_ROUND_HALF_DOWN));
                $h['777-captain-sen'] = $relative_seven;
            } catch(Exception $e) {
                $h['777-captain-sen'] = 99;
            }

        });

        try {
            return new ChartResponse($history->values()->toArray());

        } catch (Exception $e) {
            return new ErrorResponse(404, $e);
        }
    }

}