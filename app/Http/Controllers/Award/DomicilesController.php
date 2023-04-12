<?php

namespace App\Http\Controllers\Award;

use App\Models\Award;
use App\Queries\FetchAwards;
use Illuminate\Http\Request;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Resources\AwardCollection;
use App\Http\Responses\CollectionResponse;
use App\Actions\Awards\GenerateDomicilesReport;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class DomicilesController
{
    public function __construct(
        private readonly FetchAwards $query,
        private readonly GenerateDomicilesReport $report
    ) {}

    public function __invoke(Request $request)
    {
        if ($request->collect()->isNotEmpty() && $request->missing('code')) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        if ($request->has('code')) {

            if (!$request->filled('code')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            $awards = $this->query->handle(
                query: Award::query(),
                employeeNumber: null,
                code: request('code')
            )->get(['award_domicile', 'award_fleet']);

            $report = $this->report->handle($awards);

            if ($awards->isEmpty()) {
                return new EmptyResponse();
            }

            return new CollectionResponse(
                data: new AwardCollection($report)
            );
        }

        $awards = $this->query->handle(
            query: Award::query()
        )->get();

        if ($awards->isEmpty()) {
            return new EmptyResponse();
        }

        $report = $this->report->handle($awards);

        return new CollectionResponse(
            data: new AwardCollection($report)
        );
    }
}