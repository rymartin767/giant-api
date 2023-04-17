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

    $this->actingAs(sanctumToken())->get('v1/flashcards?category=6')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

// Collection Response: Collection Response
it('returns a collection response of all flashcards if no category parameter is present', function() {
    $flash = Flashcard::factory()->create();
    $flashTwo = Flashcard::factory()->create();
    
    $this->actingAs(sanctumToken())->get('v1/flashcards')
        ->assertExactJson([
            'data' => [
                [
                    'category' => $flash->category,
                    'question' => $flash->question,
                    'answer' => $flash->answer,
                    'question_image_url' => $flash->question_image_url,
                    'answer_image_url' => $flash->answer_image_url
                ],
                [
                    'category' => $flashTwo->category,
                    'question' => $flashTwo->question,
                    'answer' => $flashTwo->answer,
                    'question_image_url' => $flashTwo->question_image_url,
                    'answer_image_url' => $flashTwo->answer_image_url
                ],
        ]])
        ->assertOk();
});

// Collection Response: Collection Response (filtered)
it('returns a collection response of all flashcards in a given category', function() {
    $flash = Flashcard::factory()->create(['category' => 1]);
    Flashcard::factory()->create(['category' => 2]);
    
    $this->actingAs(sanctumToken())->get('v1/flashcards?category=1')
        ->assertExactJson([
            'data' => [
                [
                    'category' => $flash->category,
                    'question' => $flash->question,
                    'answer' => $flash->answer,
                    'question_image_url' => $flash->question_image_url,
                    'answer_image_url' => $flash->answer_image_url
                ]
        ]])
        ->assertOk();
});