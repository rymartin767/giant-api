<?php

use App\Models\Award;
use App\Models\Pilot;
use App\Models\Staffing;
use function Pest\Laravel\get;

// * UNAUTH
test('response for unauthenticated request', function() {
    get('v1/pilots/history')
        ->assertStatus(302);
});

// * EMPTY RESPONSE
it('will return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/pilots/history?employee_number=224')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

// * ERROR RESPONSE FOR MISSING EMPLOYEE NUMBER PARAM
it('will return an error response if employee parameter is missing', function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots/history')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

// * ERROR RESPONSE FOR EMPTY EMPLOYEE NUMBER PARAM
it('will return an error response if employee parameter is empty', function() {
    Pilot::factory()->has(Award::factory())->create();

    $this->actingAs(sanctumToken())->get('v1/pilots/history?employee_number=')
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

    $this->actingAs(sanctumToken())->get('v1/pilots/history?employee_numbre=224')
        ->assertExactJson([
            'error' => [
                'message' => 'Please check your request parameters.',
                'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
                'code' => 401
            ]
        ])
        ->assertStatus(401);

});

// * COLLECTION RESPONSE WITH NO YEAR PARAMETER PRESENT
it('will return a collection response for current year', function() {
    Pilot::factory()->create(['seniority_number' => 1, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 2, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 3, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 4, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 5, 'employee_number' => 450765, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 6, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 7, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 8, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 9, 'month' => '2023-01-15']);
    Pilot::factory()->create(['seniority_number' => 10, 'month' => '2023-01-15']);

    Staffing::factory()->create(['list_date' => '2023-01-15', 'total_pilot_count' => 10]);

    $this->actingAs(sanctumToken())->get('v1/pilots/history?employee_number=450765')
        ->assertExactJson([
            'data' => [
                [
                    'seniority_number' => 5,
                    'employee_number' => 450765,
                    'seat' => "CA",
                    'fleet' => "747",
                    'domicile' => "ORD",
                    'month' => "Jan 2023",
                    'aaww_total_pilots' => 10,
                    'employee_aaww_seniority_percentage' => 50
                ]
            ]
        ])
        ->assertOk();
});

// * COLLECTION RESPONSE WITH YEAR
it('will return a collection response for a given year', function() {
    Pilot::factory()->create(['seniority_number' => 1, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 2, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 3, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 4, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 5, 'employee_number' => 450765, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 6, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 7, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 8, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 9, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 10, 'month' => '2022-12-15']);
    Pilot::factory()->create(['seniority_number' => 1, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 2, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 3, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 4, 'employee_number' => 450765, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 5, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 6, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 7, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 8, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 9, 'month' => '2022-11-15']);
    Pilot::factory()->create(['seniority_number' => 10, 'month' => '2022-11-15']);

    Staffing::factory()->create(['list_date' => '2022-11-15', 'total_pilot_count' => 10]);
    Staffing::factory()->create(['list_date' => '2022-12-15', 'total_pilot_count' => 10]);


    $this->actingAs(sanctumToken())->get('v1/pilots/history?employee_number=450765&year=2022')
        ->assertExactJson([
            'data' => [
                [
                    'seniority_number' => 4,
                    'employee_number' => 450765,
                    'seat' => "CA",
                    'fleet' => "747",
                    'domicile' => "ORD",
                    'month' => "Nov 2022",
                    'aaww_total_pilots' => 10,
                    'employee_aaww_seniority_percentage' => 40
                ],
                [
                    'seniority_number' => 5,
                    'employee_number' => 450765,
                    'seat' => "CA",
                    'fleet' => "747",
                    'domicile' => "ORD",
                    'month' => "Dec 2022",
                    'aaww_total_pilots' => 10,
                    'employee_aaww_seniority_percentage' => 50
                ],
            ]
        ])
        ->assertOk();
});