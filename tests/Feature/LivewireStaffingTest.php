<?php

use Carbon\Carbon;
use App\Models\Pilot;
use Livewire\Livewire;
use App\Models\Staffing;
use function Pest\Laravel\get;
use App\Http\Livewire\Staffings;

test('staffing route is guarded by admin middleware', function() {
    get('/staffing')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('staffing livewire component is present on staffing page', function() {
    $this->actingAs(adminUser())->get('/staffing')
        ->assertSeeLivewire('staffings');
});

test('staffing livewire component shows staffing in database', function() {
    Pilot::factory()->create();
    $staffing = Staffing::factory()->create();
    $month = Carbon::parse($staffing->list_date)->format('Y-m-d');

    Livewire::test(Staffings::class)
        ->assertSee($month);
});

it('plucks the month attribute from the pilot db', function() {
    $pilot= Pilot::factory()->create();

    Livewire::test(Staffings::class)
        ->assertSee(Carbon::parse($pilot->month)->format('M Y'))
        ->assertSee('Has Staffing Report: NO');
});

// test('the generateReport method', function() {
//     Pilot::factory(10)->create(['month' => '03-15-2023']);

//     Livewire::test(Staffing::class)
//         ->call('generateReport')
//         ->assertSee('Has Staffing Report: Yes');

//     $this->assertDatabaseHas('staffing', ['list_date' => '2023-03-15', 'total_pilot_count' => 10]);
// });