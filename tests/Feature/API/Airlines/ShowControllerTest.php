<?php

use App\Models\Airline;

use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v2/airline?icao=GTI')
        ->assertStatus(302);
});

it('can return a model response', function() {
    $data = Airline::factory()->create(['icao' => 'gti']);

    $this->actingAs(sanctumToken())->get('v2/airline?icao=GTI')
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

test('response for error response for model not found', function() {
    $data = Airline::factory()->create();

    $this->actingAs(sanctumToken())->get('v2/airline?icao=ABC')
        ->assertExactJson(['error' => [
            'message' => 'Airline with ICAO code ABC not found.',
            'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'code' => 404
        ]])
        ->assertStatus(404);
});

test('response for error response for bad parameter', function() {
    $data = Airline::factory()->create(['icao' => 'GTI']);

    $this->actingAs(sanctumToken())->get('v2/airline?icoa=GTI')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});