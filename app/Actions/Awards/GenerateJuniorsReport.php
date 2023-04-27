<?php

declare(strict_types = 1);

namespace App\Actions\Awards;

use Illuminate\Support\Collection;

final readonly class GenerateJuniorsReport
{
    public function handle(Collection $awards) : Collection
    {
        
        // return collect([
        //     [
        //         'CVG 767' => '08/07/2020',
        //         'ANC 747' => '08/07/2020',
        //         'MIA 777' => '08/07/2020',
        //         'LAX 737' => '08/07/2020',
        //     ]
        // ]);

        return collect();
    }
}