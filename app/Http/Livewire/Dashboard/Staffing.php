<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Staffing as ModelsStaffing;

class Staffing extends Component
{
    public $loaded = false;
    public $status;

    public function render()
    {
        return view('livewire.dashboard.staffing');
    }

    public function initLoading() : void
    {
        if (! ModelsStaffing::all()->isEmpty()) {
            $this->status = 'Latest Staffing Report: ' . Carbon::parse(ModelsStaffing::pluck('list_date')->sortDesc()->first())->format('F Y');
        } else {
            $this->status = 'No Staffing Reports Saved!';
        }

        $this->loaded = true;
    }
}
