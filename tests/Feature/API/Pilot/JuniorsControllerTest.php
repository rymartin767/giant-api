<?php

use App\Models\Pilot;
use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/pilots/juniors')
        ->assertStatus(302);
});

it('will return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/pilots/juniors')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

it('will return an error response if a parameter is present', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots/juniors?code=')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

it('will return a collection response with correct format', function() {
    Pilot::factory()->create(['fleet' => 767, 'domicile' => 'CVG']);
    Pilot::factory()->create(['fleet' => 747, 'domicile' => 'ANC']);
    Pilot::factory()->create(['fleet' => 777, 'domicile' => 'MIA']);
    Pilot::factory()->create(['fleet' => 737, 'domicile' => 'LAX']);

    $this->actingAs(sanctumToken())->get('v1/pilots/juniors')
        ->assertExactJson([
            'data' => [
                [
                    'CVG 767' => '12/12/2023',
                    'ANC 747' => '12/12/2023',
                    'MIA 777' => '12/12/2023',
                    'LAX 737' => '12/12/2023',
                ]
            ]
        ])
        ->assertOk();
});