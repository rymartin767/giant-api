<?php

use App\Models\Scale;
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
        ->assertSee($airline->icao)
        ->assertSee('No Pay Rates Found for ' . $airline->icao);
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

test('airlines livewire component indicates if the airline has pay scales saved', function() {
    $scale = Scale::factory()->create();

    Livewire::test(Airlines::class)
        ->assertSee($scale->airline->name)
        ->assertSee($scale->airline->icao)
        ->assertSee('1 Pay Scale Found for ' . $scale->airline->icao);
});

test('airlines livewire component displays a message if the airline has no tsv data on aws s3', function() {
    Airline::factory()->create();

    Livewire::test(Airlines::class)
        ->assertSee('No AWS Scales Found!');
});

test('airlines livewire component displays a button if the airline does have tsv data on aws s3', function() {
    Airline::factory()->create(['icao' => 'GTI']);

    Livewire::test(Airlines::class)
        ->assertSee('Truncate + Reload');
});

