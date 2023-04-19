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

// No Models Exist = Empty Response (n/a)

// Error Response: Empty Parameter (n/a)

// Error Response: Bad Parameter name (n/a)

// Collection Handling: Collection Response
it('returns a collection response', function() {
    $pilot = Pilot::factory()->create(['doh' => '05/31/2005']);
    $award = Award::factory()->create(['employee_number' => $pilot->employee_number, 'is_upgrade' => true]);

    $this->actingAs(sanctumToken())->get('v1/awards/upgrades')
        ->assertExactJson(['data' => [
            [
                'award_domicile' => $award->award_domicile, 
                'award_fleet' => $award->award_fleet, 
                'award_seat' => $award->award_seat,
                'employee_number' => $award->pilot->employee_number,
                'month' => Carbon::parse($award->month)->format('M Y'),
            ]
        ]])
        ->assertOk();
});

it('returns a collection response sorted by employee number', function() {
    $awardOne = Award::factory()->create(['employee_number' => 450765, 'is_upgrade' => true]);
    $awardTwo = Award::factory()->create(['employee_number' => 450760, 'is_upgrade' => true]);

    $this->actingAs(sanctumToken())->get('v1/awards/upgrades')
        ->assertExactJson(['data' => [
            [
                'award_domicile' => $awardTwo->award_domicile, 
                'award_fleet' => $awardTwo->award_fleet, 
                'award_seat' => $awardTwo->award_seat,
                'employee_number' => $awardTwo->employee_number,
                'month' => Carbon::parse($awardTwo->month)->format('M Y'),
            ],
            [
                'award_domicile' => $awardOne->award_domicile, 
                'award_fleet' => $awardOne->award_fleet, 
                'award_seat' => $awardOne->award_seat,
                'employee_number' => $awardOne->employee_number,
                'month' => Carbon::parse($awardOne->month)->format('M Y'),
            ]
        ]])
        ->assertOk();
})->todo();
            
// Collection Handling: Empty Response
it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/awards/upgrades')
        ->assertExactJson(['data' => []])
        ->assertOk();
});
       
// Model Handling: ModelNotFound Error Response (n/a)

// Model Handling: Model Response (n/a)
