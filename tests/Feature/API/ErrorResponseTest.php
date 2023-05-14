<?php

test('api error response for route not found', function() {
    $this->actingAs(sanctumToken())->get("/v1/airlinez")
        ->assertExactJson([
            'error' => [
                'message' => 'Route Not Found',
                'type' => 'Symfony\Component\Routing\Exception\RouteNotFoundException',
                'code' => 404
            ]
        ])
        ->assertStatus(404);
});

// test('api error response for unprocessable entry exception', function() {
//     POST 422
// });