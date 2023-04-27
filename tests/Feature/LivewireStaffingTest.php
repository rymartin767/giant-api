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

test('the storeReport method', function() {
    Pilot::factory(20)->create(['month' => '2023-01-15']);
    Pilot::factory(17)->create(['month' => '2023-02-15']);
    Pilot::factory(15)->create(['month' => '2023-03-15']);

    Livewire::test(Staffings::class)
        ->call('storeStaffing')
        ->assertSet('status', 'Report Successfully Generated!');

    $this->assertDatabaseHas('staffings', ['list_date' => '2023-03-15', 'ytd_gain_loss' => -5]);
    expect(Staffing::count())->toBe(1);
});