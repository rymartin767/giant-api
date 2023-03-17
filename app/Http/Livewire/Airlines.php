<?php

namespace App\Http\Livewire;

use App\Models\Airline;
use Livewire\Component;
use App\Actions\Scales\CreateScale;
use App\Http\Requests\AirlineRequest;
use App\Actions\Scales\MakeScaleRequest;
use App\Actions\Scales\ParseTsvToCollection;
use App\Actions\Scales\ValidateScaleRequest;
use Illuminate\View\View;

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

    protected function rules() : array
    {
        return (new AirlineRequest())->rules();
    }

    public function render() : View
    {
        return view('livewire.airlines', [
            'airlines' => Airline::with('scales')->get()
        ]);
    }

    public function storeAirline() : void
    {
        $validatedData = $this->validate();

        Airline::create($validatedData);

        $this->reset();
    }

    public function importAirlineScales(int $id) : void
    {
        $airline = Airline::find($id);
        $pathToFile = "{$airline->icao}.tsv";

        $data = new ParseTsvToCollection($pathToFile);
        $rows = $data->handle();

        foreach($rows as $row) {
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
}
