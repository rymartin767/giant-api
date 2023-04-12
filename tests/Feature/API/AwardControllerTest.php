<?php

use Carbon\Carbon;
use App\Models\Award;

use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/awards')
        ->assertStatus(302);
});

it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/awards')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

it('can return an error response for empty employee_number parameter', function() {
    $this->actingAs(sanctumToken())->get('v1/awards?employee_number=')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request for an empty required parameter.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

it('can return an error response for bad parameters', function() {
    $this->actingAs(sanctumToken())->get('v1/awards?emp=2244')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

it('can return a collection response', function() {
    $awardOne = Award::factory()->create(['base_seniority' => 1, 'employee_number' => 450765]);
    $awardTwo = Award::factory()->create(['base_seniority' => 2, 'employee_number' => 450766]);

    $this->actingAs(sanctumToken())->get('v1/awards')
        ->assertExactJson(['data' => [
            [
                'base_seniority' => $awardOne->base_seniority, 
                'employee_number' => $awardOne->employee_number, 
                'domicile' => $awardOne->domicile, 
                'fleet' => $awardOne->fleet, 
                'seat' => $awardOne->seat, 
                'award_domicile' => $awardOne->award_domicile, 
                'award_fleet' => $awardOne->award_fleet, 
                'award_seat' => $awardOne->award_seat, 
                'is_new_hire' => false,
                'is_upgrade' => false,
                'month' => Carbon::parse($awardOne->month)->format('M Y'),
            ],
            [
                'base_seniority' => $awardTwo->base_seniority, 
                'employee_number' => $awardTwo->employee_number, 
                'domicile' => $awardTwo->domicile, 
                'fleet' => $awardTwo->fleet, 
                'seat' => $awardTwo->seat, 
                'award_domicile' => $awardTwo->award_domicile, 
                'award_fleet' => $awardTwo->award_fleet, 
                'award_seat' => $awardTwo->award_seat,
                'is_new_hire' => false,
                'is_upgrade' => false,
                'month' => Carbon::parse($awardTwo->month)->format('M Y'),
            ],
        ]])
        ->assertOk();
});

it('can return an model response', function() {
    $award = Award::factory()->create(['employee_number' => 224]);

    $this->actingAs(sanctumToken())->get('v1/awards?employee_number=224')
        ->assertExactJson(['data' => [
            [
                'base_seniority' => $award->base_seniority, 
                'employee_number' => $award->employee_number, 
                'domicile' => $award->domicile, 
                'fleet' => $award->fleet, 
                'seat' => $award->seat, 
                'award_domicile' => $award->award_domicile, 
                'award_fleet' => $award->award_fleet, 
                'award_seat' => $award->award_seat, 
                'is_new_hire' => false,
                'is_upgrade' => false,
                'month' => Carbon::parse($award->month)->format('M Y'),
            ],
        ]])
        ->assertOk();
});

it('can return an model not found response', 
function() {
    Award::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/awards?employee_number=2255')
        ->assertExactJson(['error' => [
            'message' => 'Award for employee number 2255 was not found.',
            'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'code' => 404
        ]])
        ->assertStatus(404);
});