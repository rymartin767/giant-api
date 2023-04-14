<?php

namespace App\Actions\Pilots;

use Exception;
use App\Models\Pilot;
use Illuminate\Support\Collection;

final readonly class GenerateStaffingReport
{
    public function handle() : Collection
    {
        try {
            $months = Pilot::pluck('month')->unique()->sortDesc()->take(2);

            $current_list = Pilot::where('month', $months->first())->get();
            $previous_list_count = Pilot::where('month', $months->last())->count();

            $jan_begin = now()->startOfYear();
            $jan_end = now()->startOfYear()->endOfMonth();
            $ytd_starting_count = Pilot::whereBetween('month', [$jan_begin, $jan_end])->count();

            $ages = collect();
            $current_list->each(fn($pilot) => $ages->push(65 - (now()->diffInYears($pilot->retire) + 1)));

            $report = collect([
                "List Date" => $months->first()->format('m/d/Y'),
                "Total" => $current_list->count(),
                "Active" => $current_list->where('active', true)->count(),
                "Inactive" => $current_list->where('active', false)->count(),
                "Net Gain/Loss" => $current_list->count() - $previous_list_count,
                "YTD Gain/Loss" => $current_list->count() - $ytd_starting_count,
                "Average Age" => round($ages->average())
            ]);

            return $report;
        } catch (Exception $exception) {
            return collect([
                'errors' => $exception
            ]);
        }
    }
}