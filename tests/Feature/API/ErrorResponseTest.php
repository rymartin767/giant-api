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
    $this->actingAs(sanctumToken())->get("/v2/airline?icao=")
        ->assertExactJson([
            'error' => [
                'message' => 'Bad or Missing Parameter',
                'type' => 'Symfony\Component\Routing\Exception\RouteNotFoundException',
                'code' => 400
            ]
    ])
    ->assertStatus(400);
});

test('api error response for model not found exception', function() {
    $this->actingAs(sanctumToken())->get("/v2/airline?icao=ABCD")
        ->assertExactJson([
            'error' => [
                'message' => 'Airline Model Not Found',
                'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
                'code' => 404
            ]
    ])
    ->assertStatus(404);
});

// test('api error response for unprocessable entry exception', function() {
//     POST 422
// });