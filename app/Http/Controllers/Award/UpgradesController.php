<?php

namespace App\Http\Controllers\Award;

use App\Models\Award;
use App\Queries\FetchAwards;
use App\Http\Responses\EmptyResponse;
use App\Http\Resources\AwardCollection;
use App\Http\Responses\CollectionResponse;

final readonly class UpgradesController
{
    public function __construct(
        private readonly FetchAwards $query
    ) {}

    public function __invoke()
    {
        $upgrades = Award::query()
            ->where('is_upgrade', true)
            ->get(['employee_number', 'award_domicile', 'award_fleet', 'award_seat', 'month'])
            ->sortBy('employee_number');

        if ($upgrades->isEmpty()) {
            return new EmptyResponse();
        }

        return new CollectionResponse(
            data: new AwardCollection($upgrades)
        );

    }
}