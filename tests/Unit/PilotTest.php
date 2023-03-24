<?php

use App\Models\Pilot;

test('pilot attribute casting for doh, retire and month', function () {
    $pilot = Pilot::factory()->create();
    $this->assertSame('immutable_date:m/d/Y', $pilot->getCasts()['doh']);
    $this->assertSame('immutable_date:m/d/Y', $pilot->getCasts()['retire']);
    $this->assertSame('immutable_date:M Y', $pilot->getCasts()['month']);
});

test('pilot doh casting format for json', function () {
    $pilot = Pilot::factory()->create(['doh' => now()]);
    $json = json_decode($pilot);
    $this->assertSame(now()->format('m/d/Y'), $json->doh);
});

test('pilot retire casting format for json', function () {
    $pilot = Pilot::factory()->create(['retire' => now()->addYears(25)]);
    $json = json_decode($pilot);
    $this->assertSame(now()->addYears(25)->format('m/d/Y'), $json->retire);
});

test('pilot month casting format for json', function () {
    $pilot = Pilot::factory()->create(['month' => now()]);
    $json = json_decode($pilot);
    $this->assertSame(now()->format('M Y'), $json->month);
});
