<?php

test('api empty response', function() {
    $this->actingAs(sanctumToken())->get("/v2/events")
        ->assertOk()
        ->assertExactJson([
            'data' => []
    ]);
});