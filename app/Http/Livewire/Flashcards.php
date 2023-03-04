<?php

namespace App\Http\Livewire;

use App\Models\Flashcard;
use Livewire\Component;

class Flashcards extends Component
{
    // FORMDATA
    public $category;
    public $question;
    public $answer;
    public $question_image_url;
    public $answer_image_url;

    public function render()
    {
        return view('livewire.flashcards', [
            'flashcards' => Flashcard::all()
        ]);
    }

    public function storeFlashcard() : void
    {
        $validatedAttributes = $this->validate([
            'category' => ['required', 'integer'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
            'question_image_url' => ['present', 'string', 'nullable'],
            'answer_image_url' => ['present', 'string', 'nullable']
        ]);

        Flashcard::create($validatedAttributes);
    }

    public function deleteFlashcard(int $id) : void
    {
        Flashcard::destroy($id);
    }
}
