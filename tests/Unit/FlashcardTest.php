<?php

use App\Models\Flashcard;

it('casts the category attribute as an enum with a full name', function () {
    $flashcard = Flashcard::factory()->create(['category' => 1]);
    $this->assertTrue($flashcard->category->name == 'LIMITATIONS');
    $this->assertTrue($flashcard->category->getFullName() == 'Limitations');
});
