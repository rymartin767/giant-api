<?php

namespace App\Http\Controllers\Pilot;

use App\Models\Pilot;
use App\Queries\FetchPilots;
use Illuminate\Http\Request;
use App\Http\Responses\EmptyResponse;
use App\Http\Resources\PilotCollection;
use App\Http\Responses\CollectionResponse;

final readonly class RetirementsListController
{
    public function __construct(
        private readonly FetchPilots $query
    ) {}

    public function __invoke(Request $request)
    {
        $retirements = $this->query->handle(
            query: Pilot::currentSeniorityList()->whereBetween('retire', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')]),
        )->get(['employee_number', 'seat', 'fleet', 'domicile', 'retire']);

        if ($retirements->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse(
            data: new PilotCollection($retirements)
        );
    }
}