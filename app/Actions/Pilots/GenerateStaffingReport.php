<?php

namespace App\Actions\Pilots;

use Exception;
use App\Models\Pilot;
use App\Models\Staffing;
use Carbon\CarbonImmutable;

final readonly class GenerateStaffingReport
{
    public function __construct(
        private CarbonImmutable $month,
    ) {}
    
    public function handle() : array
    {
        try {
            $current_list = Pilot::select('status', 'retire', 'month')->where('month', $this->month)->get();

            $jan_begin = $this->month->startOfYear();
            $jan_end = $this->month->startOfYear()->endOfMonth();

            $january = Staffing::whereBetween('list_date', [$jan_begin, $jan_end])->get();
            $january->isEmpty() ? $ytd_starting_count = 0 : $ytd_starting_count = $january->first()->total_pilot_count;

            $ages = collect();
            $current_list->each(fn($pilot) => $ages->push(65 - (now()->diffInYears($pilot->retire) + 1)));

            $previous_month = Staffing::latest('list_date')->get();
            $previous_month->isEmpty() ? $previous_count = 0 : $previous_count = $previous_month->first()->total_pilot_count;

            $array = [
                "list_date" => $this->month->format('Y-m-d'),
                "total_pilot_count" => $current_list->count(),
                "active_pilot_count" => $current_list->where('status.value', 1)->count(),
                "inactive_pilot_count" => $current_list->where('status.value', '!==', 1)->count(),
                "net_gain_loss" => $current_list->count() - $previous_count,
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