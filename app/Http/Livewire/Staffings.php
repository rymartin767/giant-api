<?php

namespace App\Http\Livewire;

use App\Models\Pilot;
use Livewire\Component;
use App\Models\Staffing;
use Carbon\Carbon;

class Staffings extends Component
{
    public $months;

    public function mount()
    {
        $collection = collect();

        foreach (Pilot::pluck('month')->sortDesc()->unique() as $month) {
            $short_date = Carbon::parse($month)->format('M Y');
            $long_date = Carbon::parse($month)->format('Y-m-d');
            $collection->put($short_date, [
                'db_date' => $long_date,
                'has_staffing_report' => Staffing::where('list_date', $long_date)->exists()
            ]);
        }

        $this->months = $collection;
    }

    public function render()
    {
        return view('livewire.staffings', [
            'months' => $this->months,
            'staffing' => Staffing::all()
        ]);
    }
}
