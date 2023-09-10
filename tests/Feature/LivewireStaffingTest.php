<?php

use Carbon\Carbon;
use App\Models\Pilot;
use Livewire\Livewire;
use App\Models\Staffing;
use function Pest\Laravel\get;
use App\Livewire\Staffings;

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