<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use App\Models\Scale;
use App\Prototypes\Employee;
use App\Queries\FetchPilots;
use App\Queries\FetchScales;
use Illuminate\Http\Request;
use App\Http\Responses\ErrorResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class EmployeeController
{
    public function __construct(
        private readonly FetchPilots $queryPilots,
        private readonly FetchScales $queryScales
    ) {}

    public function __invoke(Request $request)
    {
        // !Required Number Parameter is Missing or Empty
        if ($request->missing('number') || !$request->filled('number')) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // !Model Handling: ModelNotFound Error Response
        try {
            $pilot = $this->queryPilots->handle(
                query: Pilot::query(),
                employeeNumber: request('number')
            )->latest()->firstOrFail();

            $scales = $this->queryScales->handle(
                query: Scale::query(),
                fleet: $pilot->fleet,
            )->get(['year', 'fleet', $pilot->seat == 'CA' ? 'ca_rate' : 'fo_rate'])->toArray();
            
            $employee = new Employee($pilot, $scales);
        } catch (ModelNotFoundException) {
            $exception = new ModelNotFoundException('Pilot with number ' . request('number') . ' not found.');
            return new ErrorResponse(404, $exception);
        }

        // !Model Handling: Model Response
        return $employee->handle();
    }
}