<?php

use App\Models\Event;
use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/events')
        ->assertStatus(302);
});

test('response for authenticated request with empty data', function() {
    $this->actingAs(sanctumToken())->get('v1/events')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

test('response for authenticated request with data', function() {
    $data = Event::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/events')
        ->assertExactJson([
            'data' => [
                [
                    'id' => $data->id,
                    'title' => $data->title,
                    'date' => $data->date->format('m/d/Y'), // Model Attribute Casting
                    'time' => $data->time->format('H:i'), // Model Attribute Casting
                    'location' => $data->location,
                    'image_url' => $data->image_url,
                    'web_url' => $data->web_url
                ]
            ]
        ])
        ->assertOk();
});