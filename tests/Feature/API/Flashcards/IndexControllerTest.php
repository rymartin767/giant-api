<?php

use App\Models\Flashcard;

use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v2/flashcards')
        ->assertStatus(302);
});

test('response for authenticated request with missing category parameter', function() {
    $this->actingAs(sanctumToken())->get('v2/flashcards')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

test('response for authenticated request with empty data', function() {
    $this->actingAs(sanctumToken())->get('v2/flashcards?category=0')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

test('response for authenticated request that returns all data', function() {
    Flashcard::factory()->create([
        'category' => 1,
        'question' => 'What is the maximum operating altitude?',
        'answer' => 'FL410',
        'question_image_url' => 'question-image-url.webp',
        'answer_image_url' => 'answer-image-url.webp',
    ]);

    $this->actingAs(sanctumToken())->get('v2/flashcards?category=0')
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

test('response for authenticated request that returns filtered data', function() {
    Flashcard::factory()->create([
        'category' => 1,
        'question' => 'What is the maximum operating altitude?',
        'answer' => 'FL410',
        'question_image_url' => 'question-image-url.webp',
        'answer_image_url' => 'answer-image-url.webp',
    ]);

    $this->actingAs(sanctumToken())->get('v2/flashcards?category=1')
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

test('response for authenticated request that includes category parameter with no data', function() {
    Flashcard::factory()->create([
        'category' => 1,
        'question' => 'What is the maximum operating altitude?',
        'answer' => 'FL410',
        'question_image_url' => 'question-image-url.webp',
        'answer_image_url' => 'answer-image-url.webp',
    ]);

    $this->actingAs(sanctumToken())->get('v2/flashcards?category=2')
        ->assertExactJson(['data' => []])
        ->assertOk();
});