<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Pilot;
use Livewire\Component;
use App\Models\Staffing;
use App\Actions\Pilots\GenerateStaffingReport;
use App\Actions\Pilots\GenerateStaffingRequest;
use App\Actions\Pilots\ValidateStaffingRequest;

class Staffings extends Component
{
    public $months;
    public $status;

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

    public function storeStaffing() : void
    {
        $report = new GenerateStaffingReport;
        $data = $report->handle();

        $gsr = new GenerateStaffingRequest($data);
        $request = $gsr->handle();

        $vsr = new ValidateStaffingRequest($request);
        $validator = $vsr->handle();

        if ($validator->fails()) {
            $this->status = "Oops. Failed validation for the following error: " . $validator->errors()->first();
            return;
        } else {
            Staffing::create($request->all());
            $this->status = 'Report Successfully Generated!';
        }

        $this->mount();
    }
}
