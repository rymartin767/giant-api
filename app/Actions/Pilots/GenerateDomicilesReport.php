<?php

declare(strict_types=1);

namespace App\Actions\Pilots;

use Illuminate\Support\Collection;

final readonly class GenerateDomicilesReport
{
    public function handle(Collection $pilots) : Collection
    {
        $report = collect();

        $domiciles = $pilots->pluck('domicile')->unique();
        $domiciles->each(function($base) use ($report, $pilots) {
            $report->put($base, [
                'total' => $pilots->where('domicile', $base)->count(),
                '737' => $pilots->where('domicile', $base)->where('fleet', '737')->count(),
                '747' => $pilots->where('domicile', $base)->where('fleet', '747')->count(),
                '767' => $pilots->where('domicile', $base)->where('fleet', '767')->count(),
                '777' => $pilots->where('domicile', $base)->where('fleet', '777')->count(),
            ]);
        });

        return $report;
    }
}