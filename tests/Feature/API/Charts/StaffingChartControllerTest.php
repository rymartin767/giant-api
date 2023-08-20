<?php

use App\Models\Staffing;

use function Pest\Laravel\get;

// Unauth Response
test('response for unauthenticated request', function() {
    get('v1/charts/staffing')
        ->assertStatus(302);
});

// Empty Response
it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/charts/staffing')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

// Chart Response
it('returns a chart response', function() {
    Staffing::factory()->create(['list_date' => '2023-05-20', 'total_pilot_count' => 2700]);
    Staffing::factory()->create(['list_date' => '2023-06-20', 'total_pilot_count' => 2800]);
    Staffing::factory()->create(['list_date' => '2023-07-20', 'total_pilot_count' => 2600]);

    $this->actingAs(sanctumToken())->get('v1/charts/staffing')
        ->assertExactJson([
            'data' => [
                'May 2023' => 2700,
                'Jun 2023' => 2800,
                'Jul 2023' => 2600,
            ]
        ]);
});

