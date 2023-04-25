<?php

use App\Models\Pilot;
use App\Models\Staffing;
use function Pest\Laravel\get;

// Unauth Response
test('response for unauthenticated request', function () {
    get('v1/pilots/staffing')
        ->assertStatus(302);
});

// No Models Exist = Empty Response
it('can return an empty response', function () {
    $this->actingAs(sanctumToken())->get('v1/pilots/staffing')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

// Empty Parameter
it('will return an error response for an empty date parameter', function() {
    Pilot::factory()->create();
    Staffing::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots/staffing?date=')
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

    $this->actingAs(sanctumToken())->get('v1/pilots/staffing?daet=2023-03-15')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\\Component\\HttpFoundation\\Exception\\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);
});

// Model Handling: ModelNotFound Error Response
it('will return an error response for model not found', function() {
    Pilot::factory()->create();
    Staffing::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots/staffing?date=2023-02-15')
        ->assertExactJson(['error' => [
            'message' => 'Staffing report for 2023-02-15 not found.',
            'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'code' => 404
        ]])
        ->assertStatus(404);
});

// Model Handling: Model Response
it('will return a model response based on date in request', function () {
    Staffing::factory()->create(['list_date' => '2023-02-15']);

    $this->actingAs(sanctumToken())->get('v1/pilots/staffing?date=2023-02-15')
        ->assertExactJson([
            'data' => [
                "list_date" =>  "02/15/2023",
                "total_pilot_count" => 2800,
                "active_pilot_count" => 2693,
                "inactive_pilot_count" => 107,
                "net_gain_loss" => -14,
                "ytd_gain_loss" => -31,
                "average_age" => 45
            ]
        ]);
});

// Model Handling: Model Response (filtered)
it('will return a model response of last staffing model if no month is in the request', function () {
    Pilot::factory()->create();
    Staffing::factory()->create();
    
    $this->actingAs(sanctumToken())->get('v1/pilots/staffing')
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

