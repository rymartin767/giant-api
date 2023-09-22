<?php

namespace App\Livewire;

use App\Models\Pilot;
use Livewire\Component;
use App\Models\Staffing;
use Carbon\CarbonImmutable;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Actions\Parsers\TsvToCollection;
use App\Actions\Pilots\GeneratePilotRequest;
use App\Actions\Pilots\ValidatePilotRequest;
use App\Actions\Pilots\GenerateStaffingReport;
use App\Actions\Pilots\GenerateStaffingRequest;
use App\Actions\Pilots\ValidateStaffingRequest;
use Livewire\Features\SupportRedirects\Redirector;

class Pilots extends Component
{
    use WithPagination;
    
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

    public function storePilots()
    {
        $file = $this->selectedAwsFilePath;
        $month = CarbonImmutable::parse(str($file)->replace('-', '/')->substr(-14, 10));

        if (Pilot::where('month', $month)->exists()) {
            session()->flash('flash.bannerStyle', 'danger');
            return to_route('pilots')->with('flash.banner', 'Seniority List Already Saved for ' . Carbon::parse($month)->format('M Y') . '!');
        }

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

    public function deleteCurrentSeniorityList() : Redirector
    {
        Staffing::where('list_date', Pilot::currentSeniorityList()->first()->month)->delete();
        Pilot::currentSeniorityList()->delete();
        return to_route('pilots')->with('flash.banner', 'The current seniority list & staffing report was successfully deleted.');
    }
}
