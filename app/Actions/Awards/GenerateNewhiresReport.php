<?php

declare(strict_types=1);

namespace App\Actions\Awards;

use Illuminate\Support\Collection;

final readonly class GenerateNewhiresReport
{
    public function handle(Collection $awards) : Collection
    {
        $report = collect();

        $newhires = $awards->where('is_new_hire', true)->groupBy('award_domicile');

        $domiciles = $newhires->keys();
        
        $domiciles->each(function($base) use ($report, $awards) {
            $report->put($base, [
                'total' => $awards->where('award_domicile', $base)->where('is_new_hire', true)->count(),
                '737' => $awards->where('award_domicile', $base)->where('is_new_hire', true)->where('award_fleet', '737')->count(),
                '747' => $awards->where('award_domicile', $base)->where('is_new_hire', true)->where('award_fleet', '747')->count(),
                '767' => $awards->where('award_domicile', $base)->where('is_new_hire', true)->where('award_fleet', '767')->count(),
                '777' => $awards->where('award_domicile', $base)->where('is_new_hire', true)->where('award_fleet', '777')->count(),
            ]);
        });

        $filtered = $report->map(function($item) {
            return array_filter($item);
        });

        return $filtered;
    }
}