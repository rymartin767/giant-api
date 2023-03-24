<?php

use Livewire\Livewire;
use function Pest\Laravel\get;

test('pilots route is guarded by admin middleware', function() {
    get('/pilots')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('articles livewire component is present on articles page', function() {
    $this->actingAs(adminUser())->get('/pilots')
        ->assertSeeLivewire('pilots');
});