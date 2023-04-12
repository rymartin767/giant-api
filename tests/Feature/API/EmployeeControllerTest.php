<?php

use App\Models\Award;

use App\Models\Pilot;
use App\Models\Scale;
use App\Models\Airline;
use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/employee')
        ->assertStatus(302);
});

it('can return a model response', function() {
    $airline = Airline::factory()->has(Scale::factory())->create(['icao' => 'GTI']);
    $pilot = Pilot::factory()->has(Award::factory())->create(['fleet' => '737']);

    $this->actingAs(sanctumToken())->get('v1/employee?number=' . $pilot->employee_number)
        ->assertExactJson([
            'data' => [
                [
                    'employee_number' => $pilot->employee_number,
                    'seniority' => [
                        'seniority_number' => $pilot->seniority_number,
                        'doh' => $pilot->doh,
                        'seat' => $pilot->seat,
                        'fleet' => $pilot->fleet,
                        'domicile' => $pilot->domicile,
                        'retire' => $pilot->retire,
                        'active' => $pilot->active,
                        'month' => $pilot->month
                    ],
                    'award' => $pilot->award->only('employee_number','award_domicile','award_seat','award_fleet'),
                    'scales' => [
                        [
                            'year' => $airline->scales->first()->year,
                            'fleet' => $pilot->fleet,
                            'ca_rate' => $airline->scales->first()->ca_rate,
                        ],
                    ]
                ]
            ]
        ])
        ->assertOk();
});

test('error response for model not found', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/employee?number=123456')
        ->assertExactJson(['error' => [
            'message' => 'Pilot with number 123456 not found.',
            'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'code' => 404
        ]])
        ->assertStatus(404);
});

test('error response for bad parameter name', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/employee?numbre=224')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

test('error response for icao parameter not being filled', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/employee?number=')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});