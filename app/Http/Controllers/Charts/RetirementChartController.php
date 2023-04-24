<?php

declare(strict_types=1);

namespace App\Http\Controllers\Charts;

use Exception;
use Carbon\Carbon;
use App\Models\Pilot;
use App\Queries\FetchPilots;
use App\Http\Responses\ChartResponse;
use App\Http\Responses\ErrorResponse;

final readonly class RetirementChartController
{
    public function __construct(
        private readonly FetchPilots $query
    ) {}

    public function __invoke()
    {
        $pilots = $this->query->handle(
            query: Pilot::currentSeniorityList()
        )->get();

        try {
            $collection = $pilots->where('retire', '>', now()->format('Y'))->groupBy(function ($item) {
                return Carbon::parse($item['retire'])->format('Y');
            })->map->count()->sortKeys();
            
            return new ChartResponse($collection->all());
        } catch(Exception $e) {
            return new ErrorResponse(404, $e);
        }
    }
}