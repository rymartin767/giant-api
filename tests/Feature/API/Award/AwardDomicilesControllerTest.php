<?php

use App\Models\Award;
use App\Models\Pilot;
use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/awards/domiciles')
        ->assertStatus(302);
});

it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/awards/domiciles?code=CLE')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

test('error response for missing code parameter', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/awards/domiciles?code=')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

test('error response for bad parameter name', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/awards/domiciles?coad=CVG')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

test('it returns an collection response for a specific domicile', function() {
    Pilot::factory(5)->has(Award::factory())->create();

    $this->actingAs(sanctumToken())->get('v1/awards/domiciles?code=ORD')
        ->assertExactJson([
            'data' => [
                'ORD' => [
                    'total' => 5,
                    '737' => 0,
                    '747' => 5,
                    '767' => 0,
                    '777' => 0
                ]
            ]
        ])
        ->assertOk();

});

test('it returns an collection response with correct format', function() {
    Award::factory()->create(['award_fleet' => 767, 'award_domicile' => 'CVG']);
    Award::factory()->create(['award_fleet' => 767, 'award_domicile' => 'ANC']);
    Award::factory()->create(['award_fleet' => 777, 'award_domicile' => 'MIA']);
    Award::factory()->create(['award_fleet' => 747, 'award_domicile' => 'LAX']);

    $response = $this->actingAs(sanctumToken())->get('v1/awards/domiciles')
        ->assertExactJson([
            'data' => [
                'ANC' => [
                    'total' => 1,
                    '737' => 0,
                    '747' => 0,
                    '767' => 1,
                    '777' => 0,
                ],
                'CVG' => [
                    'total' => 1,
                    '737' => 0,
                    '747' => 0,
                    '767' => 1,
                    '777' => 0,
                ],
                'LAX' => [
                    'total' => 1,
                    '737' => 0,
                    '747' => 1,
                    '767' => 0,
                    '777' => 0,
                ],
                'MIA' => [
                    'total' => 1,
                    '737' => 0,
                    '747' => 0,
                    '767' => 0,
                    '777' => 1,
                ],
            ]
        ])
        ->assertOk();
});