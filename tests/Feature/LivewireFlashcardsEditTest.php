<?php

use Livewire\Livewire;
use App\Models\Flashcard;
use function Pest\Laravel\get;
use App\Livewire\Flashcards\Edit;

beforeEach(function () {
    Flashcard::factory()->create();
});

test('flashcards edit route is guarded by admin middleware', function() {
    get('/flashcards/1/edit')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('flashcards livewire component is present on flashcards page', function() {
    $this->actingAs(adminUser())->get('/flashcards/1/edit')
        ->assertSeeLivewire('flashcards.edit');
});

test('flashcards livewire component shows flashcard placeholder data', function() {
    $flashcard = Flashcard::find(1);

    Livewire::test(Edit::class, ['flashcard' => $flashcard])
        ->assertSee($flashcard->question)
        ->assertSee($flashcard->answer);
});

// test('component updateFlashcard method', function() {
//     $flashcard = Flashcard::find(1);

//     Livewire::test(Edit::class, ['flashcard' => $flashcard])
//         ->set('category', 1)
//         ->set('question', 'What is the maximum operating altitude?')
//         ->set('answer', 'FL410')
//         ->set('reference', 1)
//         ->set('eicas_type', null)
//         ->set('eicas_message', null)
//         ->call('updateFlashcard');
    
//     $this->assertDatabaseHas('flashcards', ['answer' => 'FL410',]);
// });

// test('component deleteFlashcard method', function() {
//     $flashcard = Flashcard::find(1);

//     Livewire::test(Edit::class, ['flashcard' => $flashcard])
//         ->call('deleteFlashcard', $flashcard->id);
    
//     $this->assertDatabaseMissing('flashcards', ['id' => $flashcard->id]);
// });

// test('existing flashcard images can be deleted', function() {
//     // 
// })->todo();

// test('existing flashcards can add images', function() {
//     // 
// })->todo();


