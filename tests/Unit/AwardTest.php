<?php

use App\Models\Award;

test('award attribute casting for is_upgrade', function () {
    $award = Award::factory()->create();
    $this->assertSame('boolean', $award->getCasts()['is_upgrade']);
});

test('award attribute casting for month', function () {
    $award = Award::factory()->create();
    $this->assertSame('immutable_date:M Y', $award->getCasts()['month']);
});

test('pilot month casting format for json', function () {
    $award = Award::factory()->create(['month' => now()]);
    $json = json_decode($award);
    $this->assertSame(now()->format('M Y'), $json->month);
});
