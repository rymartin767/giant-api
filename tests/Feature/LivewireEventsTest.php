<?php

use App\Models\Event;
use Livewire\Livewire;
use App\Http\Livewire\Events;
use function Pest\Laravel\get;

test('events route is guarded by admin middleware', function() {
    get('/events')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('events livewire component is present on events page', function() {
    $this->actingAs(adminUser())->get('/events')
        ->assertSeeLivewire('events');
});

test('events livewire component shows events in database', function() {
    Event::factory()->create();

    Livewire::test(Events::class)
        ->assertSee('Event Factory Test');
});

test('events livewire component storeEvent method', function() {
    $this->actingAs(adminUser())->get('/events');

    Livewire::test(Events::class)
        ->set('title', 'Test Event')
        ->set('date', now())
        ->set('time', '13:13')
        ->set('location', 'Miami, FL')
        ->set('existingImageUrl', 'images/events/test-image.webp')
        ->set('web_url', null)
        ->call('storeEvent')
        ->assertRedirect('events');
    
    $this->assertDatabaseHas('events', ['id' => 1, 'time' => '13:13']);
});

test('events livewire component deleteEvent method', function() {
    Event::factory()->create();

    Livewire::test(Events::class)
        ->call('deleteEvent', 1)
        ->assertDontSee('Test Event');
    
    $this->assertDatabaseMissing('events', ['id' => 1]);
});

