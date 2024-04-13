<?php

use App\Models\Flashcard;

it('casts the category attribute as an enum with a full name', function () {
    $flashcard = Flashcard::factory()->create(['category' => 1]);
    $this->assertTrue($flashcard->category->name == 'LIMITATIONS');
    $this->assertTrue($flashcard->category->getLabel() == 'Limitations');
});

it('casts the reference attribute as an enum with a full name', function () {
    $flashcard = Flashcard::factory()->create();
    $this->assertTrue($flashcard->reference->name == 'FCOM_VOL1_LIMITATIONS');
    $this->assertTrue($flashcard->reference->getLabel() == 'FCOM VOL1: Limitations');
});
