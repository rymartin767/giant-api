<?php

use App\Models\Scale;
use Livewire\Livewire;
use App\Models\Airline;
use function Pest\Laravel\get;
use App\Livewire\Airlines;

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
        ->assertSee($airline->icao . ' · ' . $airline->iata)
        ->assertSee($airline->sector);
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

it('displays count of saved pay scales for each airline', function() {
    Scale::factory(5)->create();

    Livewire::test(Airlines::class)
        ->assertSee('5');
});

it('displays a red SVG if there are no scales found on AWS S3', function() {
    Airline::factory()->create();

    Livewire::test(Airlines::class)
        ->assertSeeHtml('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="h-8 w-8 fill-current text-red-500">');
});

it('displays a green SVG if there are scales found on AWS S3', function() {
    Airline::factory()->create(['icao' => 'UPS']);

    Livewire::test(Airlines::class)
        ->assertSeeHtml('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="h-8 w-8 fill-current text-green-500">');
});

it('displays a VIEW button if the airline has pay scales saved', function() {
    Scale::factory()->create();

    Livewire::test(Airlines::class)
        ->assertSee('View');
});

it('does not display a VIEW button if the airline has pay scales saved', function() {
    Airline::factory()->create();

    Livewire::test(Airlines::class)
        ->assertDontSee('View');
});

it('displays the airlines pay scales when you click the view button', function() {
    $airline = Airline::factory()->create();

    Livewire::test(Airlines::class)
        ->call('showScales', ['airline' => $airline->id])
        ->assertSee('TRUNCATE SCALES');
});

test('truncate airline scales method', function() {
    $airline = Airline::factory()->has(Scale::factory())->create();

    $this->assertDatabaseHas('scales', ['id' => 1, 'airline_id' => $airline->id]);

    Livewire::test(Airlines::class)
        ->call('truncateScales', ['airline' => $airline->id])
        ->assertSet('selectedAirline', null);

    $this->assertDatabaseMissing('scales', ['id' => 1]);
});

