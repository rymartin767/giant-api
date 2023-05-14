<?php

use App\Models\Award;
use App\Models\Pilot;

test('award attribute casting', function () {
    $award = Award::factory()->create();
    $this->assertSame('boolean', $award->getCasts()['is_new_hire']);
    $this->assertSame('boolean', $award->getCasts()['is_upgrade']);
    $this->assertSame('immutable_date:M Y', $award->getCasts()['month']);
});

test('pilot month casting format for json', function () {
    $award = Award::factory()->create(['month' => now()]);
    $json = json_decode($award);
    $this->assertSame(now()->format('M Y'), $json->month);
});

it('belongs to a pilot', function() {
    $pilot = Pilot::factory()->create();
    $award = Award::factory()->create(['employee_number' => $pilot->employee_number]);

    expect($award->pilot)->toBeInstanceOf(Pilot::class);
});
