<?php

namespace App\Actions\Awards;

use Illuminate\Support\Collection;

final readonly class GenerateDomicilesReport
{
    public function handle(Collection $awards) : Collection
    {
        $collection = collect();

        $hubs = $awards->pluck('award_domicile')->unique();

        foreach($hubs as $hub) {
            $collection->put($hub, [
                'total' => $awards->where('award_domicile', $hub)->count(), 
                '737' => $awards->where('award_domicile', $hub)->where('award_fleet', '737')->count(),
                '747' => $awards->where('award_domicile', $hub)->where('award_fleet', '747')->count(),
                '767' => $awards->where('award_domicile', $hub)->where('award_fleet', '767')->count(),
                '777' => $awards->where('award_domicile', $hub)->where('award_fleet', '777')->count()
            ]);
        }

        return $collection->sortByDesc('total');
    }
}