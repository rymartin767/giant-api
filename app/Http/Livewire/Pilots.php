<?php

namespace App\Http\Livewire;

use App\Models\Pilot;
use Livewire\Component;
use App\Models\Staffing;
use Livewire\Redirector;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Actions\Parsers\TsvToCollection;
use App\Actions\Pilots\GeneratePilotRequest;
use App\Actions\Pilots\ValidatePilotRequest;
use App\Actions\Pilots\GenerateStaffingReport;
use App\Actions\Pilots\GenerateStaffingRequest;
use App\Actions\Pilots\ValidateStaffingRequest;

class Pilots extends Component
{
    public $selectedYear = '2023';
    public $selectedAwsFilePath;

    public $status = null;

    public function render() : View
    {

        return view('livewire.pilots', [
            'files' => Storage::disk('s3')->allFiles('/seniority-lists/v1/' . $this->selectedYear),
            'pilots' => Pilot::currentSeniorityList()->simplePaginate(50),
        ]);
    }

    public function storePilots() : void
    {
        $file = $this->selectedAwsFilePath;
        $month = CarbonImmutable::parse(str($file)->replace('-', '/')->substr(-14, 10));

        $tsv = new TsvToCollection($file);
        $rows = $tsv->handle();

        $validatedPilots = collect();

        $rows->each(function($row) use($month, $validatedPilots) {
            $cpr = new GeneratePilotRequest($row, $month);
            $request = $cpr->handle();

            $vpr = new ValidatePilotRequest($request);
            $validator = $vpr->handle();

            if ($validator->fails()) {
                $this->status = "Row #" .  $validatedPilots->count() .  " failed validation for the following error: " . $validator->errors()->first();
                return;
            } else {
                $validatedPilots->push($request->all());
            }
        });

        if ($validatedPilots->count() === $rows->count()) {
            $validatedPilots->each(fn($attributes) => Pilot::create($attributes));
            $this->storeStaffingReport($month, $rows->count());
        }
    }

    public function storeStaffingReport(CarbonImmutable $month, int $count)
    {
        $report = new GenerateStaffingReport($month);
        $data = $report->handle();

        $gsr = new GenerateStaffingRequest($data);
        $request = $gsr->handle();

        $vsr = new ValidateStaffingRequest($request);
        $validator = $vsr->handle();

        if ($validator->fails()) {
            $this->status = "Oops. Failed validation for the following error: " . $validator->errors()->first();
            return;
        } else {
            Staffing::create($request->all());
        }

        return to_route('pilots')->with('flash.banner', $count . ' pilots were successfully saved! A Staffing Report was generated!');
    }
}
