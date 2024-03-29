<?php

use Carbon\Carbon;
use App\Models\Pilot;
use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/pilots/retirements-list')
        ->assertStatus(302);
});

test('it returns an empty response for no monthly retirements', function() {
    $this->actingAs(sanctumToken())->get('v1/pilots/retirements-list')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

test('it returns an collection response for monthly retirements', function() {
    Pilot::factory(2)->create();
    $pilot = Pilot::factory()->create(['retire' => Carbon::parse(now()->startOfMonth()->addDays(20)->format('m/d/Y'))]);
    $pilotTwo = Pilot::factory()->create(['retire' => Carbon::parse(now()->startOfMonth()->format('m/d/Y'))]);

    $this->actingAs(sanctumToken())->get('v1/pilots/retirements-list')
        ->assertExactJson([
            'data' => [
                [
                    'seniority_number' => $pilot->seniority_number,
                    'seat' => $pilot->seat,
                    'fleet' => $pilot->fleet,
                    'domicile' => $pilot->domicile,
                    'retire' => Carbon::parse($pilot->retire)->format('m/d/Y')
                ],
                [
                    'seniority_number' => $pilotTwo->seniority_number,
                    'seat' => $pilotTwo->seat,
                    'fleet' => $pilotTwo->fleet,
                    'domicile' => $pilotTwo->domicile,
                    'retire' => Carbon::parse($pilotTwo->retire)->format('m/d/Y')
                ]
            ]
        ])
        ->assertOk();
});