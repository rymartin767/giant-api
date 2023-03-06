<?php

use App\Models\Airline;

use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v2/airlines')
        ->assertStatus(302);
});

it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v2/airlines')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

it('can return a collection response', function() {
    $data = Airline::factory()->create();
    $dataTwo = Airline::factory()->create();

    $this->actingAs(sanctumToken())->get('v2/airlines')
        ->assertExactJson(['data' => [
            [
                'id' => $data->id,
                'sector' => $data->sector,
                'name' => $data->name,
                'icao' => $data->icao,
                'iata' => $data->iata,
                'union' => $data->union,
                'pilot_count' => $data->pilot_count,
                'is_hiring' => $data->is_hiring,
                'web_url' => $data->web_url,
            ],
            [
                'id' => $dataTwo->id,
                'sector' => $dataTwo->sector,
                'name' => $dataTwo->name,
                'icao' => $dataTwo->icao,
                'iata' => $dataTwo->iata,
                'union' => $dataTwo->union,
                'pilot_count' => $dataTwo->pilot_count,
                'is_hiring' => $dataTwo->is_hiring,
                'web_url' => $dataTwo->web_url,
            ],
        ]])
        ->assertOk();
});

it('can return a model response', function() {
    $data = Airline::factory()->create(['icao' => 'gti']);

    $this->actingAs(sanctumToken())->get('v2/airlines?icao=GTI')
        ->assertExactJson(['data' => [
            [
                'id' => $data->id,
                'sector' => $data->sector,
                'name' => $data->name,
                'icao' => $data->icao,
                'iata' => $data->iata,
                'union' => $data->union,
                'pilot_count' => $data->pilot_count,
                'is_hiring' => $data->is_hiring,
                'web_url' => $data->web_url,
            ]
        ]])
        ->assertOk();
});

test('error response for model not found', function() {
    Airline::factory()->create();

    $this->actingAs(sanctumToken())->get('v2/airlines?icao=ABC')
        ->assertExactJson(['error' => [
            'message' => 'Airline with ICAO code ABC not found.',
            'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'code' => 404
        ]])
        ->assertStatus(404);
});

test('error response for bad parameter name', function() {
    Airline::factory()->create(['icao' => 'GTI']);

    $this->actingAs(sanctumToken())->get('v2/airlines?icoa=GTI')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

test('error response for icao parameter not being filled', function() {
    Airline::factory()->create(['icao' => 'GTI']);

    $this->actingAs(sanctumToken())->get('v2/airlines?icao=')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});