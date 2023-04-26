<?php

use App\Models\Pilot;
use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/pilots/domiciles')
        ->assertStatus(302);
});

it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/pilots/domiciles')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

test('it returns an collection response with correct format', function() {
    Pilot::factory()->create(['fleet' => 767, 'domicile' => 'CVG']);
    Pilot::factory()->create(['fleet' => 777, 'domicile' => 'CVG']);
    Pilot::factory(3)->create(['fleet' => 767, 'domicile' => 'ANC']);
    Pilot::factory(5)->create(['fleet' => 777, 'domicile' => 'MIA']);
    Pilot::factory()->create(['fleet' => 747, 'domicile' => 'LAX']);
    Pilot::factory()->create(['fleet' => 737, 'domicile' => 'LAX']);
    Pilot::factory()->create(['fleet' => 767, 'domicile' => 'LAX']);
    Pilot::factory()->create(['fleet' => 777, 'domicile' => 'LAX']);

    $this->actingAs(sanctumToken())->get('v1/pilots/domiciles')
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