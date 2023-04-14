<?php

use Carbon\Carbon;
use App\Models\Pilot;
use function Pest\Laravel\get;

test('response for unauthenticated request', function () {
    get('v1/pilots/staffing')
        ->assertStatus(302);
});

it('can return an empty response', function () {
    $this->actingAs(sanctumToken())->get('v1/pilots/staffing')
        ->assertExactJson([
            'data' => []
        ])
        ->assertOk();
});

// it('can return an error response', function() {
//     Pilot::factory()->create();

//     $this->actingAs(sanctumToken())->get('v1/pilots/staffing')
//         ->assertExactJson([
//             'error' => [
//                 'message' => 'sum ting wong',
//                 'type' => 'Exception',
//                 'code' => 401
//             ]
//         ])
//         ->assertStatus(401);

// });

it('can return a collection response', function () {
    Pilot::factory(15)->create(['retire' => Carbon::parse('05/01/2044'), 'month' => Carbon::parse('01/15/2023')]);
    Pilot::factory(10)->create(['retire' => Carbon::parse('05/01/2044'), 'month' => Carbon::parse('02/15/2023')]);
    Pilot::factory(5)->create(['retire' => Carbon::parse('05/01/2044'), 'month' => Carbon::parse('03/15/2023')]);

    $this->actingAs(sanctumToken())->get('v1/pilots/staffing')
        ->assertExactJson([
            'data' => [
                "List Date" =>  "03/15/2023",
                "Total" =>  5,
                "Active" =>  5,
                "Inactive" =>  0,
                "Net Gain/Loss" =>  -5,
                "YTD Gain/Loss" =>  -10,
                "Average Age" =>  43
            ]
        ]);
});
