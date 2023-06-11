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
        $this->status = 'Current Award: ' . Carbon::parse(Award::latest()->get()->first()?->month)->format('M Y') ?? 'NULL';

        $this->loaded = true;
    }
}

