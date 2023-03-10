<?php

use App\Models\Scale;
use App\Models\Airline;

it('belongs to an airline', function () {
    $scale = Scale::factory()->create();
    expect($scale->airline)->toBeInstanceOf(Airline::class);
});
