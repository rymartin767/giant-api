<?php

test('api error response for route not found', function() {
    $this->actingAs(sanctumToken())->get("/v2/airlinez")
        ->assertExactJson([
            'error' => [
                'message' => 'Route Not Found',
                'type' => 'Symfony\Component\Routing\Exception\RouteNotFoundException',
                'code' => 404
            ]
        ])
        ->assertStatus(404);
});

test('api error response for bad or missing parameter', function() {
    $this->actingAs(sanctumToken())->get("/v2/airlines?icao=")
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
    ])
    ->assertStatus(401);
});

test('api error response for model not found exception', function() {
    $this->actingAs(sanctumToken())->get("/v2/airlines?icao=ABC")
        ->assertExactJson([
            'error' => [
                'message' => 'Airline with ICAO code ABC not found.',
                'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
                'code' => 404
            ]
    ])
    ->assertStatus(404);
});

// test('api error response for unprocessable entry exception', function() {
//     POST 422
// });