<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Redirector;
use App\Models\Flashcard;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use App\Http\Requests\FlashcardRequest;

class Flashcards extends Component
{
    use WithFileUploads;

    // FORMDATA
    public $category;
    public $question;
    public $answer;
    public $question_image_url;
    public $answer_image_url;
    public $reference;

    public $questionImageUpload = null;
    public $answerImageUpload = null;

    public $showByCategory;

    protected function rules() : array
    {
        return (new FlashcardRequest())->rules();
    }

    public function render() : View
    {
        if ($this->showByCategory) {
            $flashcards = Flashcard::query()->where('category', $this->showByCategory)->get();
        } else {
            $flashcards = Flashcard::query()->get();
        }

        return view('livewire.flashcards', [
            'flashcards' => $flashcards
        ]);
    }

    public function storeFlashcard() : Redirector
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

        return to_route('flashcards')->with('flash.banner', 'The flashcard has been saved!');
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
