<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Airline;
use Livewire\Component;

class Airlines extends Component
{
    public $loaded = false;
    public $status;

    public function render()
    {
        return view('livewire.dashboard.airlines');
    }

    public function initLoading() : void
    {
        $this->status = 'Airline Count: ' . Airline::count();

        $this->loaded = true;
    }
}
