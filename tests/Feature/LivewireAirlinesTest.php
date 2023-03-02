<?php

use Livewire\Livewire;
use App\Models\Airline;
use function Pest\Laravel\get;
use App\Http\Livewire\Airlines;

test('airlines route is guarded by admin middleware', function() {
    get('/airlines')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('airlines livewire component is present on airlines page', function() {
    $this->actingAs(adminUser())->get('/airlines')
        ->assertSeeLivewire('airlines');
});

test('airlines livewire component shows airlines in database', function() {
    $airline = Airline::factory()->create();

    Livewire::test(Airlines::class)
        ->assertSee($airline->name)
        ->assertSee($airline->icao);
});

test('airlines livewire component storeAirline method', function() {
    Livewire::test(Airlines::class)
        ->set('sector', 1)
        ->set('name', 'Atlas Air')
        ->set('icao', 'GTI')
        ->set('iata', '5Y')
        ->set('union', 1)
        ->set('pilot_count', 2900)
        ->set('is_hiring', 1)
        ->set('web_url', 'https://atlasair.com')
        ->call('storeAirline');

    $this->assertDatabaseHas('airlines', ['id' => 1, 'name' => 'Atlas Air', 'slug' => 'atlas-air-gti']);
});

