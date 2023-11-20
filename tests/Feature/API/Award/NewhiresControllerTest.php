<?php

use App\Models\Award;
use function Pest\Laravel\get;

// Unauth Request
test('response for unauthenticated request', function() {
    get('v1/awards/newhires')
        ->assertStatus(302);
});

// Error Response: Bad Parameter name (n/a)
it('returns an error response if a parameter is in the request', function() {
    $this->actingAs(sanctumToken())->get('v1/awards/newhires?year=2020')
    ->assertExactJson(['error' => [
        'message' => 'Please check your request parameters.',
        'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
        'code' => 401
    ]])
    ->assertStatus(401);
});

// Collection Handling: Empty Response
it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/awards/newhires')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

// Collection Handling: Collection Response
it('returns a collection response', function() {
    Award::factory(10)->create(['award_domicile' => 'ANC', 'award_fleet' => '747', 'is_new_hire' => true]);
    Award::factory(5)->create(['award_domicile' => 'CVG', 'award_fleet' => '747', 'is_new_hire' => true]);
    Award::factory(5)->create(['award_domicile' => 'CVG', 'award_fleet' => '737', 'is_new_hire' => true]);
    Award::factory(5)->create(['award_domicile' => 'CVG', 'award_fleet' => '767', 'is_new_hire' => true]);
    Award::factory(5)->create(['award_domicile' => 'CVG', 'award_fleet' => '777', 'is_new_hire' => true]);
    Award::factory(8)->create(['award_domicile' => 'ONT', 'award_fleet' => '767', 'is_new_hire' => true]);
    Award::factory(2)->create(['award_domicile' => 'TPA', 'award_fleet' => '767', 'is_new_hire' => false]);

    $this->actingAs(sanctumToken())->get('v1/awards/newhires')
        ->assertExactJson([
            'data' => [
                'ANC' => [
                    'total' => 10,
                    '737' => 0,
                    '747' => 10,
                    '767' => 0,
                    '777' => 0,
                ],
                'CVG' => [
                    'total' => 20,
                    '737' => 5,
                    '747' => 5,
                    '767' => 5,
                    '777' => 5,
                ],
                'ONT' => [
                    'total' => 8,
                    '737' => 0,
                    '747' => 0,
                    '767' => 8,
                    '777' => 0,
                ]
            ]
        ])
        ->assertOk();
});