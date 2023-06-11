<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Pilot;
use Livewire\Component;

class Pilots extends Component
{
    public $loaded = false;
    public $status;

    public function render()
    {
        return view('livewire.dashboard.pilots');
    }

    public function initLoading() : void
    {
        $this->status = 'Current Seniority List: ' . Carbon::parse(Pilot::latest()->get('month')->first()->month)->format('F Y');

        $this->loaded = true;
    }
}
