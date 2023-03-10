<?php

test('api empty response', function() {
    $this->actingAs(sanctumToken())->get("/v1/events")
        ->assertOk()
        ->assertExactJson([
            'data' => []
    ]);
});