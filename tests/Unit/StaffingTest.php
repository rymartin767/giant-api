<?php

use App\Models\Pilot;
use App\Models\Staffing;

beforeEach(function () {
    Pilot::factory()->create();
});

test('staffing attribute casting', function () {
    $staffing = Staffing::factory()->create();
    $this->assertSame('immutable_date:m/d/Y', $staffing->getCasts()['list_date']);
});

test('staffing list_date casting format for json', function () {
    $staffing = Staffing::factory()->create();
    $json = json_decode($staffing);
    $this->assertSame(now()->subMonth()->startOfMonth()->addDays(14)->format('m/d/Y'), $json->list_date);
});