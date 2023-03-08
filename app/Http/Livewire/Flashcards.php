<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Flashcard;
use Livewire\WithFileUploads;

class Flashcards extends Component
{
    use WithFileUploads;

    // FORMDATA
    public $category;
    public $question;
    public $answer;
    public $question_image_url;
    public $answer_image_url;

    public $questionImageUpload = null;
    public $answerImageUpload = null;

    public function render()
    {
        return view('livewire.flashcards', [
            'flashcards' => Flashcard::all()
        ]);
    }

    public function storeFlashcard() : void
    {
        $this->validate(['questionImageUpload' => ['present', 'image', 'nullable']]);
        // $this->validate(['answerImageUpload' => ['present', 'image', 'nullable']]);

        $validatedAttributes = $this->validate([
            'category' => ['required', 'integer'],
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ]);

        if ($this->questionImageUpload !== null) {
            $this->question_image_url = $this->storeUploadedImage('question');
            $this->validate(['question_image_url' => ['required', 'string']]);
            $validatedAttributes['question_image_url'] = $this->question_image_url;
        } else {
            $validatedAttributes['question_image_url'] = null;
        }
        
        if ($this->answerImageUpload !== null) {
            $this->answer_image_url = $this->storeUploadedImage('answer');
            $this->validate(['answer_image_url' => ['required', 'string']]);
            $validatedAttributes['answer_image_url'] = $this->answer_image_url;
        } else {
            $validatedAttributes['answer_image_url'] = null;
        }

        Flashcard::create($validatedAttributes);
    }

    public function storeUploadedImage(string $type) : String
    {
        if ($type == 'question') {
            $url = $this->questionImageUpload->store('images/flashcards/development', 's3');
        } else {
            $url = $this->answerImageUpload->store('images/flashcards/development', 's3');
        }

        return (string) $url;
    }

    public function deleteFlashcard(int $id) : void
    {
        Flashcard::destroy($id);
    }
}
