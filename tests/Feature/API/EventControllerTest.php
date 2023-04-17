<?php

use App\Models\Event;
use function Pest\Laravel\get;

// Unauth Response
test('response for unauthenticated request', function() {
    get('v1/events')
        ->assertStatus(302);
});

// No Models Exist = Empty Response
it('returns an empty response for no model data', function() {
    $this->actingAs(sanctumToken())->get('v1/events')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

// Error Response: Empty Parameter
// Error Response: Bad Parameter

// Collection: Handling Collection Response        
it('returns a collection response of events', function() {
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

// Empty Response if collection is empty

// Model Handling: ModelNotFound Error Response
// Model Handling: Model Response