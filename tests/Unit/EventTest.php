<?php

use App\Models\Event;

test('event attribute casting for date and time', function () {
    $event = Event::factory()->create();
    $this->assertSame('immutable_datetime:m/d/Y', $event->getCasts()['date']);
    $this->assertSame('immutable_datetime:H:i', $event->getCasts()['time']);
});

test('event date casting format for json', function () {
    $event = Event::factory()->create(['date' => now()]);
    $json = json_decode($event);
    $this->assertSame(now()->format('m/d/Y'), $json->date);
});

test('event time casting format for json', function () {
    $event = Event::factory()->create(['time' => '23:23:23']);
    $json = json_decode($event);
    $this->assertSame('23:23', $json->time);
});