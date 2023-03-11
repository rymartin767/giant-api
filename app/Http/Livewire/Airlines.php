<?php

namespace App\Http\Livewire;

use App\Models\Airline;
use Livewire\Component;
use App\Prototypes\ImportedScale;
use App\Actions\Scales\CreateScale;
use App\Actions\Scales\MakeScaleRequest;
use Illuminate\Support\Facades\Pipeline;
use App\Actions\Scales\ParseTsvToCollection;
use App\Actions\Scales\ValidateScaleRequest;

class Airlines extends Component
{
    //  FORMDATA
    public $sector;
    public $name;
    public $icao;
    public $iata;
    public $union;
    public $pilot_count;
    public $is_hiring;
    public $web_url;
    public $slug;

    public function render()
    {
        return view('livewire.airlines', [
            'airlines' => Airline::with('scales')->get()
        ]);
    }

    public function storeAirline()
    {
        $validatedData = $this->validate([
            'sector' => ['required', 'integer'],
            'name' => ['required', 'string', 'min:8', 'max:35'],
            'icao' => ['required', 'string', 'size:3'],
            'iata' => ['required', 'string', 'size:2'],
            'union' => ['required', 'integer'],
            'pilot_count' => ['required', 'integer', 'max:17000'],
            'is_hiring' => ['required', 'boolean'],
            'web_url' => ['required', 'string', 'starts_with:https://'],
            'slug' => []
        ]);

        Airline::create($validatedData);

        $this->reset();
    }

    public function importAirlineScales(int $id)
    {
        // $airline = Airline::find($id);
        // $pathToFile = "{$airline->icao}.tsv";
        // $data = new ParseTsvToCollection($pathToFile);
        // $rows = $data->handle();
        // foreach($rows as $row) {
        //     $importedScale = new ImportedScale($airline->id, $row);
            
        //     $scale = Pipeline::send($importedScale)
        //         ->through([
        //             GenerateProfilePhoto::class,
        //             ActivateSubscription::class,
        //             SendWelcomeEmail::class,
        //         ])
        //         ->then(fn (User $user) => $user);

            //     $createRequest = new MakeScaleRequest($row);
            //     $newRequest = $createRequest->handle();

            //     $validator = new ValidateScaleRequest($newRequest);
            //     $request = $validator->handle();

            //     $validatedData = $request->validated();
                
            //     $scale = new CreateScale($validatedData);
            //     $scale = $scale->handle();
        // }
    }
}
