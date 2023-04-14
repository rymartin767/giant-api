<?php 

namespace App\Http\Controllers\Pilot;

use Carbon\Carbon;
use App\Models\Pilot;
use Illuminate\Http\Request;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Resources\PilotCollection;
use App\Http\Responses\CollectionResponse;
use App\Actions\Pilots\GenerateStaffingReport;

final readonly class StaffingController
{
    public function __construct(
        private readonly GenerateStaffingReport $report
    ) {}

    public function __invoke(Request $request)
    {
        if (!Pilot::exists()) {
            return new EmptyResponse();
        }

        $report = $this->report->handle();

        if ($report->has('errors')) {
            return new ErrorResponse(401, $report['errors']);
        }

        return new CollectionResponse(
            data: new PilotCollection($report)
        );
    }
}