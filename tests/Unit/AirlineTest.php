<?php

use App\Models\Airline;
use App\Models\Scale;

it('has a dedicated path', function () {
    $airline = Airline::factory()->create();
    expect($airline->path())->toEqual("/airlines/$airline->icao");
});

test('airline hiring attribute casting to boolean', function () {
    $airline = Airline::factory()->create();
    expect($airline->is_hiring)->toBeBool();
});

test('airline name attribute setter to title case', function () {
    $airline = Airline::factory()->create(['name' => 'atlas air']);
    expect($airline->name)->toEqual('Atlas Air');
});

test('airline icao attribute setter to uppercase', function () {
    $airline = Airline::factory()->create(['icao' => 'gti']);
    expect($airline->icao)->toEqual('GTI');
});

test('airline slug attribute setter to name and icao', function () {
    $airline = Airline::factory()->create(['name' => 'Atlas Air', 'icao' => 'gti']);
    expect($airline->slug)->toEqual('atlas-air-gti');
});

test('airline sector attribute enum', function () {
    $airline = Airline::factory()->create(['sector' => 1]);
    $this->assertTrue($airline->sector->name == 'CARGO');
    $this->assertTrue($airline->sector->getFullName() == 'Cargo');
});

test('airline union attribute enum', function () {
    $airline = Airline::factory()->create(['union' => 1]);
    $this->assertTrue($airline->union->name == 'IBT');
    $this->assertTrue($airline->union->getFullName() == 'International Brotherhood of Teamsters');
});

it('has a scope for Atlas', function () {
    Airline::factory()->create(['name' => 'atlas air', 'icao' => 'gti']);
    $airline = Airline::atlas()->first();
    expect($airline->icao)->toBe('GTI');
});

it('has a (pay) scales relationship', function() {
    $airline = Airline::factory()
            ->has(Scale::factory())
            ->create();

    expect($airline->scales->first())->toBeInstanceOf(Scale::class);
});

test('airline model hasAwsFile method', function() {
    $airline = Airline::factory()->create(['icao' => 'GTI']);
    expect($airline->hasAwsScales())->toBe(true);
});