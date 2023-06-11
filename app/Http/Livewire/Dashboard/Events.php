<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Event;
use Livewire\Component;

class Events extends Component
{
    public $loaded = false;
    public $status;

    public function render()
    {
        return view('livewire.dashboard.events');
    }

    public function initLoading() : void
    {
        $this->status = 'Updated Until ' . Carbon::parse(Event::pluck('date')->sortDesc()->first())->format('F jS, Y');

        $this->loaded = true;
    }
}

