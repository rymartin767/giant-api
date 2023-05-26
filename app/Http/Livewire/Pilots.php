<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Pilot;
use Livewire\Component;
use Livewire\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Actions\Parsers\TsvToCollection;
use App\Actions\Pilots\GeneratePilotRequest;
use App\Actions\Pilots\ValidatePilotRequest;

class Pilots extends Component
{
    public $selectedYear = '2023';
    public $selectedAwsFilePath;

    public $status = null;

    public function render() : View
    {

        return view('livewire.pilots', [
            'files' => Storage::disk('s3')->allFiles('/seniority-lists/' . $this->selectedYear),
            'pilots' => Pilot::currentSeniorityList()->simplePaginate(50),
        ]);
    }

    public function storePilots() : Redirector
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
            return to_route('pilots')->with('flash.banner', $rows->count() . ' pilots were successfully saved!');
        }
    }
}
