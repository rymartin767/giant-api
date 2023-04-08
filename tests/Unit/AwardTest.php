<?php

use App\Models\Award;

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
