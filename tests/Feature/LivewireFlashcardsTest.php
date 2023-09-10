<?php

use Livewire\Livewire;
use App\Models\Flashcard;
use function Pest\Laravel\get;
use App\Livewire\Flashcards;

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
        ->set('reference', 1)
        ->call('storeFlashcard')
        ->assertSee('Limitations');
    
    $this->assertDatabaseHas('flashcards', ['id' => 1, 'category' => 1]);
});

test('links are present to edit each flashcard', function() {
    Flashcard::factory()->create();

    $r = Livewire::test(Flashcards::class)
        ->assertSeeHtml('<a href="http://giant-api.test/flashcards/1/edit">');
});

