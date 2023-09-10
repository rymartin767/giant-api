<?php

namespace App\Livewire;

use Livewire\Component;

class Charts extends Component
{
    public function render()
    {
        return view('livewire.charts', [
            'tooltip' => 'Tooltip',
            'collection' => collect([
                'JAN' => 1000,
                'FEB' => 500,
                'MAR' => 400,
            ])
        ]);
    }
}
