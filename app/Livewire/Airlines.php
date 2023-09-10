<?php

namespace App\Livewire;

use App\Models\Airline;
use Livewire\Component;
use Illuminate\View\View;
use App\Actions\Scales\CreateScale;
use App\Http\Requests\AirlineRequest;
use App\Actions\Parsers\TsvToCollection;
use App\Actions\Scales\MakeScaleRequest;
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

    public $selectedAirline;
    public $fleetTypes;
    public $selectedFleet;

    protected function rules() : array
    {
        return (new AirlineRequest())->rules();
    }

    public function render() : View
    {
        return view('livewire.airlines', [
            'airlines' => Airline::withCount('scales')->get()
        ]);
    }

    public function storeAirline() : void
    {
        $validatedData = $this->validate();

        Airline::create($validatedData);

        $this->reset();

        session()->flash('message', 'Airline successfully created.');
    }

    public function importAirlineScales(Airline $airline) : void
    {
        $pathToFile = "pay-scales/{$airline->icao}.tsv";

        $data = new TsvToCollection($pathToFile);
        $rows = $data->handle();

        foreach($rows as $row) {
            $row = collect($row);
            $row->put('airline_id', $airline->id);
            $createRequest = new MakeScaleRequest($row);
            $newRequest = $createRequest->handle();

            $validator = new ValidateScaleRequest($newRequest);
            $request = $validator->handle();

            $validatedData = $request->validated();

            $create = new CreateScale($airline, $validatedData);
            $create->handle();
        }
    }

    public function showScales(Airline $airline) : void
    {
        $this->selectedAirline = $airline->load('scales');
        $this->fleetTypes = $this->selectedAirline->scales->pluck('fleet.value')->unique();
        $this->selectedFleet = $this->fleetTypes->first();
    }

    public function truncateScales(Airline $airline) : void
    {
        $airline->scales()->delete();
        $this->selectedAirline = null;
    }
}
