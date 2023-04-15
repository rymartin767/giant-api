<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Pilot;
use Livewire\Component;
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

    public $status = 'This is the status after the pilots are stored!';

    public function render() : View
    {
        return view('livewire.pilots', [
            'files' => Storage::disk('s3')->allFiles('/seniority-lists/' . $this->selectedYear),
            'pilots' => Pilot::currentSeniorityList()->paginate(5)
        ]);
    }

    public function storePilots() : void
    {
        $file = $this->selectedAwsFilePath;
        $month = Carbon::parse(str($file)->replace('-', '/')->substr(-14, 10));

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
        }

        // if(Pilot::count() === $rows->count()) {
        //     $report = new GenerateStaffingReport;
        //     $array = $report->handle();

        //     $gsr = new GenerateStaffingRequest($array);
        //     $request = $gsr->handle();

        //     $vsr = new ValidateStaffingRequest($request);
        //     $validator = $vsr->handle();

        //     if ($validator->fails()) {
        //         $this->status = $validator->errors()->first();
        //     } else {
        //         $attributes = $request->all();
        //         Staffing::create($attributes);
        //     }
        // }
    }
}
