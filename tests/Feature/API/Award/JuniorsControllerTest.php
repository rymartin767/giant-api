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
    Pilot::factory()->has(Award::factory(['base_seniority' => 5, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'CA']))->create(['doh' => '2019-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 4, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'CA']))->create(['doh' => '2018-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 3, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'CA']))->create(['doh' => '2015-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 2, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'CA']))->create(['doh' => '2014-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 1, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'CA']))->create(['doh' => '2012-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 6, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'CA']))->create(['doh' => '2020-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 3, 'award_domicile' => 'MIA', 'award_fleet' => '777', 'award_seat' => 'CA']))->create(['doh' => '2018-05-31']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 2, 'award_domicile' => 'MIA', 'award_fleet' => '777', 'award_seat' => 'CA']))->create(['doh' => '2016-05-31']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 1, 'award_domicile' => 'MIA', 'award_fleet' => '777', 'award_seat' => 'CA']))->create(['doh' => '2014-08-07']);

    $this->actingAs(sanctumToken())->get('v1/awards/juniors?seat=CA')
        ->assertExactJson([
            'data' => [
                'award_date' => 'March 2024',
                'dohs' => [
                    'MIA 777' => '05/31/2018',
                    'ANC 747' => '08/07/2020',
                ]
            ]
        ])
        ->assertOk();
});

// * COLLECTION RESPONSE
it('will return a collection response with correct format for first officers', function() {
    Pilot::factory()->has(Award::factory(['base_seniority' => 1, 'award_domicile' => 'MIA', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2015-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 2, 'award_domicile' => 'MIA', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2016-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 3, 'award_domicile' => 'MIA', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2017-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 4, 'award_domicile' => 'MIA', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2018-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 5, 'award_domicile' => 'MIA', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2019-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 6, 'award_domicile' => 'MIA', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2015-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 1, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2015-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 2, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2016-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 3, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2017-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 4, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => false]))->create(['doh' => '2018-08-07']);
    Pilot::factory()->has(Award::factory(['base_seniority' => 5, 'award_domicile' => 'ANC', 'award_fleet' => '747', 'award_seat' => 'FO', 'is_new_hire' => true]))->create();

    $this->actingAs(sanctumToken())->get('v1/awards/juniors?seat=FO')
        ->assertExactJson([
            'data' => [
                'award_date' => 'March 2024',
                'dohs' => [
                    'MIA 747' => '08/07/2015',
                    'ANC 747' => 'New Hire'
                ]
            ]
        ])
        ->assertOk();
});