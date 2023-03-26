<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Pilot;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Actions\Parsers\TsvToCollection;
use App\Actions\Pilots\CreatePilotRequest;
use App\Actions\Pilots\ValidatePilotRequest;

class Pilots extends Component
{
    public $selectedYear = '2023';
    public $selectedAwsFilePath;

    public $status;

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

        foreach ($rows as $pilot) {
            $cpr = new CreatePilotRequest($pilot, $month);
            $request = $cpr->handle();
            $vpr = new ValidatePilotRequest($request);
            $validator = $vpr->handle();
            if ($validator->fails()) {
                $this->status = $validator->errors()->first();
            } else {
                $validated = $request->all();
                $validatedPilots->push($validated);
            }
        }

        $validatedPilots->each(fn($attributes) => Pilot::create($attributes));
    }
}
