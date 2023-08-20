<?php

use App\Models\Pilot;
use function Pest\Laravel\get;

// Unauth Response
test('response for unauthenticated request', function() {
    get('v1/charts/pilots/retirements')
        ->assertStatus(302);
});

// Chart Response
it('returns a chart response', function() {
    Pilot::factory(5)->create(['retire' => '2023-05-20']);
    Pilot::factory(6)->create(['retire' => '2024-06-20']);
    Pilot::factory()->create(['retire' => '2025-06-20']);

    $this->actingAs(sanctumToken())->get('v1/charts/pilots/retirements')
        ->assertExactJson([
            'data' => [
                '2023' => 5,
                '2024' => 6,
                '2025' => 1,
            ]
        ]);
});

