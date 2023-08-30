<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use App\Models\Scale;
use App\Models\Staffing;
use App\Queries\FetchPilots;
use App\Queries\FetchScales;
use Illuminate\Http\Request;
use App\Queries\FetchStaffing;
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
        private readonly FetchPilots $queryPilots,
        private readonly FetchScales $queryScales,
        private readonly FetchStaffing $queryStaffing,
    ) {}

    public function __invoke(Request $request)
    {
        // * No Models Exist = Empty Response
        if (! Pilot::exists()) {
            return new EmptyResponse();
        }

        // * Employee Number Parameter is Present (Model Response)
        if ($request->has('employee_number')) {
            if (!$request->filled('employee_number')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            // * Model Handling
            try {
                $pilot = $this->queryPilots->handle(
                    query: Pilot::query(),
                    employeeNumber: request('employee_number')
                )->with('award:employee_number,award_domicile,award_fleet,award_seat,month')->orderBy('month', 'desc')->firstOrFail();

                $scales = $this->queryScales->handle(
                    query: Scale::query(),
                    icao: 'GTI',
                    fleet: $pilot->fleet,
                )->get(['year', 'fleet', $pilot->seat == 'CA' ? 'ca_rate' : 'fo_rate'])->toArray();

                $pay_year = today()->diffInYears($pilot['doh']) + 1;
                $service = today()->diff($pilot['doh']);
                $seat = $pilot->seat == 'CA' ? 'ca_rate' : 'fo_rate';
                $current_rate = collect($scales)->where('year', $pay_year)->first()[$seat];

                $pilot->compensation = [
                    'service' => $service->y . ' YEARS + ' . $service->m . ' MONTH',
                    'current_rate' => $current_rate,
                    'scales' => $scales
                ];

                $count = $this->queryStaffing->handle(
                    query: Staffing::query(),
                    year: null,
                    date: $pilot->month
                )->get()->sole()->total_pilot_count;

                $pilot->seniority = [
                    'seniority_number' => $pilot->seniority_number,
                    'total_pilots' => $count,
                    'seniority_percent' => ceil(round(($pilot->seniority_number / $count) * 100, 1, PHP_ROUND_HALF_DOWN))
                ];

            } catch (ModelNotFoundException) {
                $exception = new ModelNotFoundException('Pilot with employee number ' . request('employee_number') . ' was not found.');
                return new ErrorResponse(404, $exception);
            }
    
            // * Model Response
            return new ModelResponse($pilot);

        }

        // ! Employee Number Parameter is Missing (Collection Response)
            
        // * Error Response: Bad Parameter
        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // * Collection Handling
        $pilots = $this->queryPilots->handle(
            query: Pilot::currentSeniorityList(),
        )->get();

        // * Collection Handling: Empty Response
        if ($pilots->isEmpty())
        {
            return new EmptyResponse();
        }

        // * Collection Handling: Collection Response
        return new CollectionResponse(
            data: new PilotCollection($pilots)
        );
    }
}