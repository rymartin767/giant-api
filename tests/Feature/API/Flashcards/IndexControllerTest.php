<?php

use App\Models\Flashcard;

use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v2/flashcards')
        ->assertStatus(302);
});

test('response for authenticated request with empty data', function() {
    $this->actingAs(sanctumToken())->get('v2/flashcards')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

test('response for authenticated request with data', function() {
    $data = Flashcard::factory()->create([
        'category' => 1,
        'question' => 'What is the maximum operating altitude?',
        'answer' => 'FL410',
        'question_image_url' => 'question-image-url.webp',
        'answer_image_url' => 'answer-image-url.webp',
    ]);

    $this->actingAs(sanctumToken())->get('v2/flashcards')
        ->assertExactJson(['data' => [
            [
                'category' => 1,
                'question' => 'What is the maximum operating altitude?',
                'answer' => 'FL410',
                'question_image_url' => 'question-image-url.webp',
                'answer_image_url' => 'answer-image-url.webp',
            ]
        ]])
        ->assertOk();
});