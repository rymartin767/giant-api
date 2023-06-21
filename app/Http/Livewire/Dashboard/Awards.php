<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Award;
use Carbon\Carbon;
use Livewire\Component;

class Awards extends Component
{
    public $loaded = false;
    public $status;

    public function render()
    {
        return view('livewire.dashboard.awards');
    }

    public function initLoading() : void
    {
        if (! Award::all()->isEmpty()) {
            $this->status = 'Current Award: ' . Carbon::parse(Award::orderByDesc('month')->first()?->month)->format('M Y');
        } else {
            $this->status = 'No Awards Saved!';
        }

        $this->loaded = true;
    }
}

