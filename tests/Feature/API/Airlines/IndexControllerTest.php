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