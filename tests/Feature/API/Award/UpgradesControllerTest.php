<?php

use Carbon\Carbon;
use App\Models\Award;
use App\Models\Pilot;
use function Pest\Laravel\get;

// Unauth Request
test('response for unauthenticated request', function() {
    get('v1/awards/upgrades')
        ->assertStatus(302);
});

// Error Response: Bad Parameter name (n/a)
it('returns an error response if a parameter is in the request', function() {
    $this->actingAs(sanctumToken())->get('v1/awards/upgrades?domicile=ord')
    ->assertExactJson(['error' => [
        'message' => 'Please check your request parameters.',
        'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
        'code' => 401
    ]])
    ->assertStatus(401);
});

// Collection Handling: Collection Response
it('returns a collection response', function() {
    $pilot = Pilot::factory()->has(Award::factory(['is_upgrade' => true]))->create(['doh' => '05/31/2005']);

    $this->actingAs(sanctumToken())->get('v1/awards/upgrades')
        ->assertExactJson(['data' => [
            [
                'award_domicile' => $pilot->award->award_domicile, 
                'award_fleet' => $pilot->award->award_fleet, 
                'award_seat' => $pilot->award->award_seat,
                'employee_number' => $pilot->award->pilot->employee_number,
                'doh' => '05/31/2005',
                'month' => Carbon::parse($pilot->award->month)->format('M Y'),
            ]
        ]])
        ->assertOk();
});

it('returns a collection response sorted by employee number', function() {
    Pilot::factory()->create(['employee_number' => 450760, 'doh' => '05/31/2005']);
    Pilot::factory()->create(['employee_number' => 450765, 'doh' => '05/31/2005']);
    $awardOne = Award::factory()->create(['employee_number' => 450765, 'is_upgrade' => true]);
    $awardTwo = Award::factory()->create(['employee_number' => 450760, 'is_upgrade' => true]);

    $this->actingAs(sanctumToken())->get('v1/awards/upgrades')
        ->assertExactJson(['data' => [
            [
                'award_domicile' => $awardTwo->award_domicile, 
                'award_fleet' => $awardTwo->award_fleet, 
                'award_seat' => $awardTwo->award_seat,
                'employee_number' => $awardTwo->employee_number,
                'doh' => '05/31/2005',
                'month' => Carbon::parse($awardTwo->month)->format('M Y'),
            ],
            [
                'award_domicile' => $awardOne->award_domicile, 
                'award_fleet' => $awardOne->award_fleet, 
                'award_seat' => $awardOne->award_seat,
                'employee_number' => $awardOne->employee_number,
                'doh' => '05/31/2005',
                'month' => Carbon::parse($awardOne->month)->format('M Y'),
            ]
        ]])
        ->assertOk();
});
            
// Collection Handling: Empty Response
it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/awards/upgrades')
        ->assertExactJson(['data' => []])
        ->assertOk();
});