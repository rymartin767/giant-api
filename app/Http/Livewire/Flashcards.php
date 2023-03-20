<?php

namespace App\Http\Livewire;

use App\Http\Requests\FlashcardRequest;
use Livewire\Component;
use App\Models\Flashcard;
use Illuminate\View\View;
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

    protected function rules() : array
    {
        return (new FlashcardRequest())->rules();
    }

    public function render() : View
    {
        return view('livewire.flashcards', [
            'flashcards' => Flashcard::all()
        ]);
    }

    public function storeFlashcard() : void
    {
        if ($this->questionImageUpload !== null) {
            $this->validate([
                'questionImageUpload' => ['required', 'image', 'mimes:jpg,png,webp'],
            ]);
            $this->question_image_url = $this->storeUploadedImage('question');
        }
        
        if ($this->answerImageUpload !== null) {
            $this->validate([
                'answerImageUpload' => ['required', 'image', 'mimes:jpg,png,webp']
            ]);
            $this->answer_image_url = $this->storeUploadedImage('answer');
        }

        $validatedAttributes = $this->validate();
        Flashcard::create($validatedAttributes);
    }

    public function storeUploadedImage(string $type) : string
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