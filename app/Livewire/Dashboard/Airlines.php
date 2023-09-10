<?php

namespace App\Livewire\Dashboard;

use App\Models\Airline;
use Livewire\Component;

class Airlines extends Component
{
    public $status;

    public function mount() {
        $this->status = 'Airline Count: ' . Airline::count();
    }

    public function render()
    {
        return view('livewire.dashboard.airlines');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            LOADING RIGHT NOW
        </div>
        HTML;
    }
}
