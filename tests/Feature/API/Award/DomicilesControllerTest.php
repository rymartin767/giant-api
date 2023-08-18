<?php

use App\Models\Award;

use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/awards/domiciles')
        ->assertStatus(302);
});

it('will return an error response for a request with a bad parameter', function() {
    Award::factory()->create(['award_fleet' => 767, 'award_domicile' => 'CVG']);

    $this->actingAs(sanctumToken())->get('v1/awards/domiciles?seat=ca')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\\Component\\HttpFoundation\\Exception\\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);
});

it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/awards/domiciles')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

test('it returns an collection response with correct format', function() {
    Award::factory()->create(['award_fleet' => 767, 'award_domicile' => 'CVG']);
    Award::factory()->create(['award_fleet' => 777, 'award_domicile' => 'CVG']);
    Award::factory(3)->create(['award_fleet' => 767, 'award_domicile' => 'ANC']);
    Award::factory(5)->create(['award_fleet' => 777, 'award_domicile' => 'MIA']);
    Award::factory()->create(['award_fleet' => 747, 'award_domicile' => 'LAX']);
    Award::factory()->create(['award_fleet' => 737, 'award_domicile' => 'LAX']);
    Award::factory()->create(['award_fleet' => 767, 'award_domicile' => 'LAX']);
    Award::factory()->create(['award_fleet' => 777, 'award_domicile' => 'LAX']);

    $this->actingAs(sanctumToken())->get('v1/awards/domiciles')
        ->assertExactJson([
            'data' => [
                'ANC' => [
                    'total' => 3,
                    '737' => 0,
                    '747' => 0,
                    '767' => 3,
                    '777' => 0,
                ],
                'CVG' => [
                    'total' => 2,
                    '737' => 0,
                    '747' => 0,
                    '767' => 1,
                    '777' => 1,
                ],
                'LAX' => [
                    'total' => 4,
                    '737' => 1,
                    '747' => 1,
                    '767' => 1,
                    '777' => 1,
                ],
                'MIA' => [
                    'total' => 5,
                    '737' => 0,
                    '747' => 0,
                    '767' => 0,
                    '777' => 5,
                ],
            ]
        ])
        ->assertOk();
});