<?php

use App\Models\Scale;
use App\Models\Airline;

use function Pest\Laravel\get;

// Unauthenticated Response for missing Sanctum Token
test('response for unauthenticated request', function() {
    get('v1/scales')
        ->assertStatus(302);
});

// Optional Parameter is missing or empty
test('error response for icao parameter not being filled', function() {
    Airline::factory()->has(Scale::factory())->create(['icao' => 'GTI']);

    $this->actingAs(sanctumToken())->get('v1/scales?icao=')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

// Bad Parameter name
test('error response for bad parameter name', function() {
    Airline::factory()->has(Scale::factory())->create(['icao' => 'GTI']);

    $this->actingAs(sanctumToken())->get('v1/scales?icoa=GTI')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

// Collection Handling: Empty Response if airline doesnt exist
it('can return a collection response if no airline exists based on icao parameter', function() {
    $this->actingAs(sanctumToken())->get('v1/scales?icao=JBU')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

// Collection Handling: Empty Response if collection is empty
it('can return a collection response if no airline scales exist', function() {
    Airline::factory()->create(['icao' => 'JBU']);

    $this->actingAs(sanctumToken())->get('v1/scales?icao=JBU')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

// Collection Handling: Collection Response for one airline
it('can return a collection response of scales for a single airline', function() {
    $airline = Airline::factory()->has(Scale::factory())->create(['icao' => 'GTI']);
    $scales = Scale::factory()->create(['airline_id' => $airline->id, 'year' => 2, 'ca_rate' => 200.20, 'fo_rate' => 100.10]);

    $this->actingAs(sanctumToken())->get('v1/scales?icao=GTI')
        ->assertExactJson([
            'data' => [
                [
                    'year' => $airline->scales->first()->year,
                    'fleet' => $airline->scales->first()->fleet,
                    'ca_rate' => $airline->scales->first()->ca_rate,
                    'fo_rate' => $airline->scales->first()->fo_rate,
                ],
                [
                    'year' => $scales->year,
                    'fleet' => $scales->fleet,
                    'ca_rate' => $scales->ca_rate,
                    'fo_rate' => $scales->fo_rate,
                ]
            ]
        ])
        ->assertOk();
});

// Collection Handling: Collection Response for two airlines
it('can return a collection response of scales for multiple airlines', function() {
    $gti = Airline::factory()->has(Scale::factory())->create(['icao' => 'GTI']);
    $ups = Airline::factory()->has(Scale::factory())->create(['icao' => 'UPS']);

    $this->actingAs(sanctumToken())->get('v1/scales?icao=GTI,UPS')
        ->assertExactJson([
            'data' => [
                'GTI' => [
                    [
                        'year' => $gti->scales->first()->year,
                        'fleet' => $gti->scales->first()->fleet,
                        'ca_rate' => $gti->scales->first()->ca_rate,
                        'fo_rate' => $gti->scales->first()->fo_rate,
                    ],
                ],
                'UPS' => [
                    [
                        'year' => $ups->scales->first()->year,
                        'fleet' => $ups->scales->first()->fleet,
                        'ca_rate' => $ups->scales->first()->ca_rate,
                        'fo_rate' => $ups->scales->first()->fo_rate,
                    ]
                ],
            ]
        ])
        ->assertOk();
});