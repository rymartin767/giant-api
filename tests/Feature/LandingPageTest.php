<?php

use function Pest\Laravel\get;

test('the app has a landing page', function () {
    get('/')
        ->assertStatus(200);
});

it('has links to login and register', function () {
    get('/')
        ->assertSee('Log in')
        ->assertSee('Register');
});
