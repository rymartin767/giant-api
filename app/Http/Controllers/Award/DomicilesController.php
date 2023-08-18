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
        // * NO AWARDS = EMPTY RESPONSE
        if (! Award::exists()) {
            return new EmptyResponse();
        }
        
        // * REQUEST PARAMS = ERROR RESPONSE
        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

         // * COLLECTION RESPONSE
        $awards = $this->query->handle(
            query: Award::query()
        )->get();

        $report = $this->report->handle($awards);

        return new CollectionResponse(
            data: new AwardCollection($report)
        );
    }
}