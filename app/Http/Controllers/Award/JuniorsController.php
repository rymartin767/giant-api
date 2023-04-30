<?php

declare(strict_types =1);

namespace App\Http\Controllers\Award;

use App\Models\Award;
use App\Queries\FetchAwards;
use Illuminate\Http\Request;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Resources\AwardCollection;
use App\Http\Responses\CollectionResponse;
use App\Actions\Awards\GenerateJuniorsReport;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class JuniorsController
{
    public function __construct(
        private readonly FetchAwards $query,
    ) {}

    public function __invoke(Request $request)
    {
        // * NO AWARDS
        if (! Award::exists()) {
            return new EmptyResponse();
        }

        // * REQUEST MISSING SEAT PARAM
        if ($request->missing('seat')) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // * REQUEST SEAT PARAM IS EMPTY
        if (! $request->filled('seat')) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // * REQUEST SEAT PARAM VALUE IS BAD
        if ($request->filled('seat') && request('seat') !== 'CA' && request('seat') !== 'FO') {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }
        
        // * REQUEST HAS BAD PARAMs
        if (! $request->collect()->isEmpty() && $request->missing('seat')) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // * COLLECTION RESPONSE
        $awards = $this->query->handle(
            query: Award::query(),
            employeeNumber: null,
            domicile: null
        )->with('pilot:employee_number,doh')->get(['employee_number', 'award_domicile', 'award_fleet', 'award_seat']);

        $report =  new GenerateJuniorsReport($awards);
        $captains = $report->handle(request('seat'));

        return new CollectionResponse(
            data: new AwardCollection($captains)
        );
    }
}