<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Award;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Actions\Parsers\TsvToCollection;

class Awards extends Component
{
    public $selectedYear;
    public $selectedAwsFilePath;

    public $status = 'This is the status after the awards are stored!';

    public function render() : View
    {
        return view('livewire.awards', [
            'files' => Storage::disk('s3')->allFiles('/vacancy-awards/' . $this->selectedYear),
            'awards' => Award::query()->paginate(25)
        ]);
    }

    // public function storeAwards() : void
    // {
    //     $file = $this->selectedAwsFilePath;
    //     $month = Carbon::parse(str($file)->replace('-', '/')->substr(-14, 10));

    //     $tsv = new TsvToCollection($file);
    //     $rows = $tsv->handle();

    //     $validatedPilots = collect();

    //     foreach ($rows as $pilot) {
    //         $cpr = new CreatePilotRequest($pilot, $month);
    //         $request = $cpr->handle();
    //         $vpr = new ValidatePilotRequest($request);
    //         $validator = $vpr->handle();
    //         if ($validator->fails()) {
    //             $this->status = $validator->errors()->first();
    //         } else {
    //             $validated = $request->all();
    //             $validatedPilots->push($validated);
    //         }
    //     }

    //     $validatedPilots->each(fn($attributes) => Pilot::create($attributes));
    // }

    public function truncateAwards() : void{
        Award::truncate();
    }
}
