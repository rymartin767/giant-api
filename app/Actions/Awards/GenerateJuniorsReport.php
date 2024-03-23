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

    private function month() : string
    {
        return $this->awards->first()->month->format('F Y');
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
        $juniors = collect();
        $collection->put('award_date', $this->month());
        
        $this->positions()->map(function($position) use($juniors) {
            $base = explode(" ", $position)[0];
            $fleet = explode(" ", $position)[1];

            $junior_in_base_award = $this->awards->where('award_domicile', $base)->where('award_seat', 'CA')->where('award_fleet', $fleet)->where('omit_from_juniors', false)->sortBy('base_seniority')->last();

            if (! $junior_in_base_award == null) {
                $juniors->put($position, Carbon::parse($junior_in_base_award->pilot->doh)->format('m/d/Y'));
            };
        });

        $collection->put('dohs', $juniors);
        $collection = $collection->sort();
        return $collection;
    }

    private function firstOfficers() : Collection
    {
        $collection = collect();
        $juniors = collect();
        $collection->put('award_date', $this->month());
        
        $this->positions()->map(function($position) use($juniors) {
            $base = explode(" ", $position)[0];
            $fleet = explode(" ", $position)[1];

            $junior_in_base_award = $this->awards->where('award_domicile', $base)->where('award_seat', 'FO')->where('award_fleet', $fleet)->sortBy('base_seniority')->last();

            if (! $junior_in_base_award == null) {
                $juniors->put($position, $junior_in_base_award->is_new_hire ? 'New Hire' : Carbon::parse($junior_in_base_award->pilot->doh)->format('m/d/Y'));
            };
        });

        $collection->put('dohs', $juniors);
        $collection = $collection->sort();
        return $collection;
    }
}