<?php

namespace App\Http\Livewire;

use App\Models\Airline;
use Livewire\Component;

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
            'airlines' => Airline::all()
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
        
        $this->dispatchBrowserEvent('flash-message');

        $this->reset();
    }
}
