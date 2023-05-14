<?php

namespace App\Http\Controllers\Pilot;

use App\Models\Pilot;
use App\Queries\FetchPilots;
use Illuminate\Http\Request;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Resources\PilotCollection;
use App\Http\Responses\CollectionResponse;
use App\Actions\Pilots\GenerateDomicilesReport;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class DomicilesController
{
    public function __construct(
        private readonly FetchPilots $query,
        private readonly GenerateDomicilesReport $report
    ) {}

    public function __invoke(Request $request)
    {
        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        $pilots = $this->query->handle(
            query: Pilot::currentSeniorityList()
        )->get(['doh', 'seat', 'fleet', 'domicile']);

        if ($pilots->isEmpty()) {
            return new EmptyResponse();
        }

        $report = $this->report->handle($pilots);

        return new CollectionResponse(
            data: new PilotCollection($report)
        );
    }
}