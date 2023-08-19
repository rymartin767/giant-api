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

// * ERROR RESPONSE FOR MISSING SEAT PARAM
it('will return an error response if seat parameter is missing', function() {
    Pilot::factory()->has(Award::factory())->create();

    $this->actingAs(sanctumToken())->get('v1/awards/juniors')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

// * ERROR RESPONSE FOR EMPTY SEAT PARAM
it('will return an error response if seat parameter is empty', function() {
    Pilot::factory()->has(Award::factory())->create();

    $this->actingAs(sanctumToken())->get('v1/awards/juniors?seat=')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

// * ERROR RESPONSE FOR INCORRECT SEAT PARAM VALUE
it('will return an error response if seat parameter value is not CA or FO', function() {
    Pilot::factory()->has(Award::factory())->create();

    $this->actingAs(sanctumToken())->get('v1/awards/juniors?seat=FA')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

// * ERROR RESPONSE FOR BAD PARAMETER
it('will return an error response for a bad parameter', function() {
    Pilot::factory()->has(Award::factory())->create();

    $this->actingAs(sanctumToken())->get('v1/awards/juniors?sete=CA')
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
it('will return a collection response with correct format for captains', function() {
    Pilot::factory()->has(Award::factory(['award_domicile' => 'CVG', 'award_fleet' => '767']))->create(['doh' => '2020-08-07']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'MIA', 'award_fleet' => '747']))->create(['doh' => '2014-05-31']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'MIA', 'award_fleet' => '747']))->create(['doh' => '2016-05-31']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'ANC', 'award_fleet' => '747']))->create(['doh' => '2019-08-07']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'MIA', 'award_fleet' => '777']))->create(['doh' => '2018-08-07']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'PDX', 'award_fleet' => '737']))->create(['doh' => '2017-08-07']);

    $this->actingAs(sanctumToken())->get('v1/awards/juniors?seat=CA')
        ->assertExactJson([
            'data' => [
                'MIA 747' => '05/31/2014',
                'PDX 737' => '08/07/2017',
                'MIA 777' => '08/07/2018',
                'ANC 747' => '08/07/2019',
                'CVG 767' => '08/07/2020',
            ]
        ])
        ->assertOk();
});

// * COLLECTION RESPONSE
it('will return a collection response with correct format for first officers', function() {
    Pilot::factory()->has(Award::factory(['award_domicile' => 'CVG', 'award_fleet' => '767', 'award_seat' => 'FO', 'is_new_hire' => true]))->create();
    Pilot::factory()->has(Award::factory(['award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => true]))->create();
    Pilot::factory()->has(Award::factory(['award_domicile' => 'MIA', 'award_fleet' => '777', 'award_seat' => 'FO']))->create(['doh' => '2022-09-14']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'PDX', 'award_fleet' => '737', 'award_seat' => 'FO']))->create(['doh' => '2022-08-07']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'PDX', 'award_fleet' => '737', 'award_seat' => 'FO']))->create(['doh' => '2022-10-07']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'CVG', 'award_fleet' => '767', 'award_seat' => 'FO']))->create(['doh' => '2022-10-07']);
    Pilot::factory()->has(Award::factory(['award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'FO']))->create(['doh' => '2022-10-07']);

    $this->actingAs(sanctumToken())->get('v1/awards/juniors?seat=FO')
        ->assertExactJson([
            'data' => [
                'PDX 737' => '08/07/2022',
                'MIA 777' => '09/14/2022',
                'ANC 747' => 'New Hire',
                'CVG 767' => 'New Hire',
            ]
        ])
        ->assertOk();
});