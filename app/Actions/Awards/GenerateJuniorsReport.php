<?php

declare(strict_types = 1);

namespace App\Actions\Awards;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final readonly class GenerateJuniorsReport
{
    public function __construct(protected Collection $awards) {}

    public function handle(string $seat) : Collection
    {
        if ($seat == 'CA') {
            return $this->captains();
        }

        if ($seat == 'FO') {
            return $this->firstOfficers();
        }
    }

    private function positions()
    {
        return collect([
            'ANC 747',
            'CVG 737',
            'CVG 747',
            'CVG 767',
            'CVG 777',
            'IAH 747',
            'IAH 767',
            'JFK 747',
            'JFK 767',
            'LAX 747',
            'LAX 777',
            'MEM 747',
            'MIA 747',
            'MIA 777',
            'ORD 747',
            'ONT 767',
            'PDX 737',
            'PDX 767',
            'TPA 767',
        ]);
    }

    private function captains() : Collection
    {
        $collection = collect();
        
        $this->positions()->map(function($position) use($collection) {
            $base = explode(" ", $position)[0];
            $fleet = explode(" ", $position)[1];

            $results = $this->awards->where('award_domicile', $base)->where('award_seat', 'CA')->where('award_fleet', $fleet)->sortBy('base_seniority');

            if (! $results->isEmpty()) {
                $collection->put($position, Carbon::parse($results->first()->pilot->doh)->format('m/d/Y'));
            }
        });

        $collection = $collection->sort();
        return $collection;
    }

    private function firstOfficers() : Collection
    {
        $collection = collect();
        
        $this->positions()->map(function($position) use($collection) {
            $base = explode(" ", $position)[0];
            $fleet = explode(" ", $position)[1];

            $results = $this->awards->where('award_domicile', $base)->where('award_seat', 'FO')->where('award_fleet', $fleet)->sortBy('base_seniority');

            if (! $results->isEmpty()) {
                $collection->put($position, $results->first()->is_new_hire ? 'New Hire' : Carbon::parse($results->first()->pilot->doh)->format('m/d/Y'));
            }
        });

        $collection = $collection->sort();
        return $collection;
    }
}