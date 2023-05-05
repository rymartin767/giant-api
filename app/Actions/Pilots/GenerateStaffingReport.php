<?php

namespace App\Actions\Pilots;

use Exception;
use App\Models\Pilot;

final readonly class GenerateStaffingReport
{
    public function handle() : array
    {
        try {
            $months = Pilot::pluck('month')->unique()->sortDesc()->take(2);

            $current_list = Pilot::where('month', $months->first()->format('Y-m-d'))->get();
            $previous_list_count = Pilot::where('month', $months->last()->format('Y-m-d'))->count();

            $jan_begin = now()->startOfYear();
            $jan_end = now()->startOfYear()->endOfMonth();
            $ytd_starting_count = Pilot::whereBetween('month', [$jan_begin, $jan_end])->count();

            $ages = collect();
            $current_list->each(fn($pilot) => $ages->push(65 - (now()->diffInYears($pilot->retire) + 1)));

            $array = [
                "list_date" => $months->first()->format('Y-m-d'),
                "total_pilot_count" => $current_list->count(),
                "active_pilot_count" => $current_list->where('status.value', 1)->count(),
                "inactive_pilot_count" => $current_list->where('status.value', '!==', 1)->count(),
                "net_gain_loss" => $current_list->count() - $previous_list_count,
                "ytd_gain_loss" => $current_list->count() - $ytd_starting_count,
                "average_age" => round($ages->average())
            ];

            return $array;
        } catch (Exception $exception) {
            return [
                'errors' => $exception
            ];
        }
    }
}