<?php

use App\Models\Pilot;
use App\Models\Staffing;
use function Pest\Laravel\get;

// Unauth Response
test('response for unauthenticated request', function () {
    get('v1/staffing')
        ->assertStatus(302);
});

// No Models Exist = Empty Response
it('can return an empty response', function () {
    $this->actingAs(sanctumToken())->get('v1/staffing')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

// Empty Collection (based on year parameter) = Empty Response
it('can return an empty collection response', function () {
    $this->actingAs(sanctumToken())->get('v1/staffing?year=2020')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

// Empty Parameter
it('will return an error response for an empty year parameter', function() {
    Pilot::factory()->create();
    Staffing::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/staffing?year=')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\\Component\\HttpFoundation\\Exception\\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);
});

// Bad Parameter name
it('will return an error response for an bad parameter', function() {
    Pilot::factory()->create();
    Staffing::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/staffing?yaer=2023')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\\Component\\HttpFoundation\\Exception\\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);
});

// Model Handling: Model Response (filtered)
it('will return a model response of last staffing model if no year is in the request', function () {
    Pilot::factory()->create();
    Staffing::factory()->create();
    
    $this->actingAs(sanctumToken())->get('v1/staffing')
        ->assertExactJson([
            'data' => [
                "list_date" => now()->subMonth()->startOfMonth()->addDays(14)->format('m/d/Y'),
                "total_pilot_count" => 2800,
                "active_pilot_count" => 2693,
                "inactive_pilot_count" => 107,
                "net_gain_loss" => -14,
                "ytd_gain_loss" => -31,
                "average_age" => 45
            ]
        ]);
});

// Collection Handling: filtered
it('will return a collection response of staffing reports by year', function () {
    Staffing::factory()->create([
        "list_date" => '2022-11-15',
        "total_pilot_count" => 2700,
        "active_pilot_count" => 2593,
        "inactive_pilot_count" => 107,
        "net_gain_loss" => -10,
        "ytd_gain_loss" => -26,
        "average_age" => 44
    ]);

    Staffing::factory()->create([
        "list_date" => '2022-12-15',
        "total_pilot_count" => 2800,
        "active_pilot_count" => 2693,
        "inactive_pilot_count" => 107,
        "net_gain_loss" => -14,
        "ytd_gain_loss" => -31,
        "average_age" => 45
    ]);
    
    $this->actingAs(sanctumToken())->get('v1/staffing?year=2022')
        ->assertExactJson([
            'data' => [
                [
                    "list_date" => '11/15/2022',
                    "total_pilot_count" => 2700,
                    "active_pilot_count" => 2593,
                    "inactive_pilot_count" => 107,
                    "net_gain_loss" => -10,
                    "ytd_gain_loss" => -26,
                    "average_age" => 44
                ],
                [
                    "list_date" => '12/15/2022',
                    "total_pilot_count" => 2800,
                    "active_pilot_count" => 2693,
                    "inactive_pilot_count" => 107,
                    "net_gain_loss" => -14,
                    "ytd_gain_loss" => -31,
                    "average_age" => 45
                ],
            ]
        ]);
});

