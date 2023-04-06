<?php

test('dashboard page middleware for non admin', function () {
    $this->get('/dashboard')->assertStatus(302);
});

test('dashboard page middleware for admin users', function () {
    $this->actingAs(adminUser())->get('/dashboard')->assertStatus(200);
});

test('it has titles to each model resource', function() {
    $this->actingAs(adminUser())->get('/dashboard')
        ->assertSee('Airlines')
        ->assertSee('Articles')
        ->assertSee('Awards')
        ->assertSee('Events')
        ->assertSee('Flashcards')
        ->assertSee('Pilots');
});
