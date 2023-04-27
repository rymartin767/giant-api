<?php

use App\Models\Award;
use App\Models\Pilot;
use function Pest\Laravel\get;

// * UNAUTH
test('response for unauthenticated request', function() {
    get('v1/awards/juniors')
        ->assertStatus(302);
});

// * EMPTY RESPONSE
it('will return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/awards/juniors')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

// * ERROR RESPONSE
it('will return an error response if a parameter is present', function() {
    Pilot::factory()->has(Award::factory())->create();

    $this->actingAs(sanctumToken())->get('v1/awards/juniors?code=')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

// * COLLECTION RESPONSE
it('will return a collection response with correct format', function() {
    Pilot::factory()->has(Award::factory())->create(['doh' => '2020-07-08', 'fleet' => 767, 'domicile' => 'CVG']);
    Pilot::factory()->has(Award::factory())->create(['doh' => '2020-07-08', 'fleet' => 747, 'domicile' => 'ANC']);
    Pilot::factory()->has(Award::factory())->create(['doh' => '2020-07-08', 'fleet' => 777, 'domicile' => 'MIA']);
    Pilot::factory()->has(Award::factory())->create(['doh' => '2020-07-08', 'fleet' => 737, 'domicile' => 'LAX']);

    $this->actingAs(sanctumToken())->get('v1/awards/juniors')
        ->assertExactJson([
            'data' => [
                [
                    'CVG 767' => '08/07/2020',
                    'ANC 747' => '08/07/2020',
                    'MIA 777' => '08/07/2020',
                    'LAX 737' => '08/07/2020',
                ]
            ]
        ])
        ->assertOk();
})->todo();