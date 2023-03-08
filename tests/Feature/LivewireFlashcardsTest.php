<?php

use Livewire\Livewire;
use App\Models\Flashcard;
use function Pest\Laravel\get;
use App\Http\Livewire\Flashcards;

test('flashcards route is guarded by admin middleware', function() {
    get('/flashcards')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('flashcards livewire component is present on flashcards page', function() {
    $this->actingAs(adminUser())->get('/flashcards')
        ->assertSeeLivewire('flashcards');
});

test('flashcards livewire component shows flashcards in database', function() {
    Flashcard::factory()->create(['category' => 1]);

    Livewire::test(Flashcards::class)
        ->assertSee('Limitations');
});

test('Flashcards livewire component storeFlashcard method', function() {
    $this->actingAs(adminUser())->get('/flashcards');

    Livewire::test(Flashcards::class)
        ->set('category', 1)
        ->set('question', 'What is the maximum operating altitude?')
        ->set('answer', 'FL410')
        ->set('question_image_url', null)
        ->set('answer_image_url', null)
        ->call('storeFlashcard')
        ->assertSee('Limitations');
    
    $this->assertDatabaseHas('flashcards', ['id' => 1, 'category' => 1]);
});

test('flashcards livewire component deleteFlashcard method', function() {
    $flashcard = Flashcard::factory()->create();

    Livewire::test(Flashcards::class)
        ->call('deleteFlashcard', $flashcard->id);
    
    $this->assertDatabaseMissing('flashcards', ['id' => $flashcard->id]);
});

