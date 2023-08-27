<?php

use Carbon\Carbon;
use App\Models\Award;
use App\Models\Pilot;
use App\Models\Scale;
use App\Models\Airline;
use App\Models\Staffing;
use function Pest\Laravel\get;

// Unauth Response
test('response for unauthenticated request', function() {
    get('v1/pilots')
        ->assertStatus(302);
});

// Empty Response
it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/pilots')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

// Error Response: Bad Parameter name
it('will return an error response for a bad param', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots?emp=2244')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

// Error Response: Empty Parameter
it('will return an error response for empty param', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots?emp=')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

// Model Handling: ModelNotFound Error Response
it('will return an model not found response', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots?employee_number=2255')
        ->assertExactJson(['error' => [
            'message' => 'Pilot with employee number 2255 was not found.',
            'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'code' => 404
        ]])
        ->assertStatus(404);
});

// Model Handling: Model Response
it('will return an model response with latest award, scales (per seniority not award), and seniority', function() {
    seedPilots(25, '04/15/2023');
    Airline::factory()->has(Scale::factory(['year' => 10, 'fleet' => 'B767', 'ca_rate' => 283.31]))->create(['icao' => 'GTI']);
    $pilot = Pilot::factory()->has(Award::factory(['award_fleet' => '747', 'award_seat' => 'CA', 'award_domicile' => 'MIA']))->create(['seniority_number' => 26, 'employee_number' => 450765, 'fleet' => '767', 'doh' => '2014-06-30']);
    Staffing::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots?employee_number=450765')
        ->assertExactJson([
            'data' => [
                'seniority_number' => 26, 
                'employee_number' => 450765, 
                'doh' => Carbon::parse($pilot->doh)->format('m/d/Y'), 
                'seat' => 'CA', 
                'fleet' => '767', 
                'domicile' => 'ORD', 
                'retire' => Carbon::parse($pilot->retire)->format('m/d/Y'),
                'status' => $pilot->status, 
                'month' => Carbon::parse($pilot->month)->format('M Y'),
                'award' => [
                    'employee_number' => $pilot->employee_number,
                    'award_seat' => 'CA',
                    'award_fleet' => '747',
                    'award_domicile' => 'MIA',
                    'month' => $pilot->award->month->format('M Y')
                ],
                'compensation' => [
                    'current_rate' => 283.31,
                    'scales' => [
                        [
                            'year' => 10,
                            'fleet' => 'B767',
                            'ca_rate' => 283.31,
                        ],
                    ],
                ],
                'seniority' => [
                    'seniority_number' => 26,
                    'total_pilots' => 2800,
                    'seniority_percent' => 1
                ]
            ]
        ])
        ->assertOk();
});

// Collection Response: Collection Response
it('can return an collection response', function() {
    $pilotOne = Pilot::factory()->create(['seniority_number' => 1, 'employee_number' => 450765]);
    $pilotTwo = Pilot::factory()->create(['seniority_number' => 2, 'employee_number' => 450766]);
    
    $this->actingAs(sanctumToken())->get('v1/pilots')
        ->assertExactJson([
            'data' => [
                [
                    'seniority_number' => $pilotOne->seniority_number, 
                    'employee_number' => $pilotOne->employee_number, 
                    'doh' => Carbon::parse($pilotOne->doh)->format('m/d/Y'), 
                    'seat' => $pilotOne->seat, 
                    'fleet' => $pilotOne->fleet, 
                    'domicile' => $pilotOne->domicile, 
                    'retire' => Carbon::parse($pilotOne->retire)->format('m/d/Y'),
                    'status' => $pilotOne->status, 
                    'month' => Carbon::parse($pilotOne->month)->format('M Y'),
                ],
                [
                    'seniority_number' => $pilotTwo->seniority_number, 
                    'employee_number' => $pilotTwo->employee_number, 
                    'doh' => Carbon::parse($pilotTwo->doh)->format('m/d/Y'), 
                    'seat' => $pilotTwo->seat, 
                    'fleet' => $pilotTwo->fleet, 
                    'domicile' => $pilotTwo->domicile, 
                    'retire' => Carbon::parse($pilotTwo->retire)->format('m/d/Y'),
                    'status' => $pilotTwo->status, 
                    'month' => Carbon::parse($pilotTwo->month)->format('M Y'),
                ],
            ]
        ])
        ->assertOk();
});