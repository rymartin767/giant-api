<?php

namespace App\Http\Controllers\Award;

use App\Models\Award;
use App\Models\Pilot;
use App\Queries\FetchAwards;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Resources\AwardCollection;
use App\Http\Responses\CollectionResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class UpgradesController
{
    public function __construct(
        private readonly FetchAwards $query
    ) {}

    public function __invoke(Request $request)
    {
        if (! $request->collect()->isEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        $upgrades = Award::query()
            ->where('is_upgrade', true)
            ->get(['employee_number', 'award_domicile', 'award_fleet', 'award_seat', 'month'])
            ->sortBy('employee_number')->values(); //sortBy keeps original keys so we use values to reset them
        
        if ($upgrades->isEmpty()) {
            return new EmptyResponse();
        }

        $upgrades->each(function ($upgrade) {
            $doh = Pilot::where('employee_number', $upgrade->employee_number)->first()->doh;
            $upgrade['doh'] = Carbon::parse($doh)->format('m/d/Y');
        });

        return new CollectionResponse(
            data: new AwardCollection($upgrades)
        );

    }
}