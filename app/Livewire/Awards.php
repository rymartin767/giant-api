<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Award;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Actions\Parsers\TsvToCollection;
use App\Actions\Awards\CreateAwardRequest;
use App\Actions\Awards\ValidateAwardRequest;

class Awards extends Component
{
    use WithPagination;
    
    public $selectedYear;
    public $selectedAwsFilePath;

    public $status;

    public function render() : View
    {
        return view('livewire.awards', [
            'files' => Storage::disk('s3')->allFiles('/vacancy-awards/' . $this->selectedYear),
            'awards' => Award::query()->orderBy('employee_number')->paginate(25)
        ]);
    }

    public function storeAwards() : void
    {
        $file = $this->selectedAwsFilePath;
        $month = Carbon::parse(str($file)->replace('_', ' ')->substr(-12, 8));

        $tsv = new TsvToCollection($file);
        $rows = $tsv->handle();

        $validatedAwards = collect();

        foreach ($rows as $award) {
            $car = new CreateAwardRequest($award, $month);
            $request = $car->handle();
            $var = new ValidateAwardRequest($request);
            $validator = $var->handle();
            if ($validator->fails()) {
                $this->status = $validator->errors()->first();
            } else {
                $validated = $request->all();
                $validatedAwards->push($validated);
            }
        }

        $validatedAwards->each(fn($attributes) => Award::create($attributes));
        $this->status = $validatedAwards->count() . ' Awards have been validated & saved!';
    }

    public function truncateAwards() : void
    {
        Award::truncate();
    }

    public function deleteAward($employee_number) : void
    {
        $award = Award::where('employee_number', $employee_number)->sole();
        $award->delete();
    }
}
