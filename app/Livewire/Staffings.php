<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staffing;

class Staffings extends Component
{
    public function render()
    {
        return view('livewire.staffings', [
            'staffing' => Staffing::all()
        ]);
    }
}
