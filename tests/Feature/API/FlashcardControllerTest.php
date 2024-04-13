<?php

use App\Models\Flashcard;

use function Pest\Laravel\get;

// Unauth Response
test('response for unauthenticated request', function() {
    get('v1/flashcards')
        ->assertStatus(302);
});

// No Models Exist = Empty Response
it('returns and empty response for no model data', function() {
    $this->actingAs(sanctumToken())->get('v1/flashcards')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

// Error Response: Empty Parameter
it('returns an error response for category parameter not being filled', function() {
    Flashcard::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/flashcards?category=')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

// Error Response: Bad Parameter name
it('returns an error response for a bad parameter', function() {
    Flashcard::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/flashcards?categoy=2')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

// Collection Handling: Empty Response
it('returns an empty response if flashcard category returns an empty collection', function() {
    Flashcard::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/flashcards?category=61')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

// Collection Response: Collection Response
it('returns a collection response of all flashcards by count param', function() {
    Flashcard::factory()->create();
    Flashcard::factory()->create();
    
    $cards = $this->actingAs(sanctumToken())->get('v1/flashcards?count=2');

    expect($cards['data'])->toHaveCount(2);
});

// Collection Response: Collection Response (filtered by category)
it('returns a collection response of all flashcards in a given category', function() {
    Flashcard::factory(2)->create(['category' => 1]);
    Flashcard::factory()->create(['category' => 2]);
    
    $cards = $this->actingAs(sanctumToken())->get('v1/flashcards?category=1');

    expect($cards['data'])
        ->toBeArray()
        ->toHaveCount(2);
});

// Collection Response: Collection Response (filtered by reference)
it('returns a collection response of all flashcards in a given reference', function() {
    Flashcard::factory(3)->create(['reference' => 1]);
    Flashcard::factory()->create(['reference' => 2]);
    
    $cards = $this->actingAs(sanctumToken())->get('v1/flashcards?reference=1');

    expect($cards['data'])->toHaveCount(3);
});

// Collection Response: Collection Response (filtered by count)
it('returns a collection response of all flashcards limited to count', function() {
    Flashcard::factory(10)->create();
    
    $response = $this->actingAs(sanctumToken())->get('v1/flashcards?count=5')
        ->assertOk();

    expect($response->json()['data'])->toHaveCount(5);
});

// Collection Response: Collection Response (filtered by category and count)
it('returns a collection response of flashcards in a given category limited by count', function() {
    Flashcard::factory(3)->create(['category' => 1]);
    Flashcard::factory(2)->create(['category' => 2]);
    
    $cards = $this->actingAs(sanctumToken())->get('v1/flashcards?category=1&count=3');

    expect($cards['data'])->toHaveCount(3);

    $this->assertDatabaseHas('flashcards', ['category' => 2]);
});