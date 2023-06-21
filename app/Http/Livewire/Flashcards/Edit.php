<?php

namespace App\Http\Livewire\Flashcards;

use Livewire\Component;
use Livewire\Redirector;
use App\Models\Flashcard;
use Livewire\WithFileUploads;
use App\Http\Requests\FlashcardRequest;

class Edit extends Component
{
    use WithFileUploads;

    public Flashcard $flashcard;

    // FORMDATA
    public $category;
    public $question;
    public $answer;
    public $reference;
    public $eicas_type;
    public $eicas_message;

    public $questionImageUpload = null;
    public $answerImageUpload = null;

    protected function rules() : array
    {
        return (new FlashcardRequest())->rules();
    }

    public function mount(Flashcard $flashcard)
    {
        $this->flashcard = $flashcard;
        $this->eicas_message = $flashcard->eicas_message;
    }

    public function render()
    {
        return view('livewire.flashcards.edit');
    }

    public function updateFlashcard() : Redirector
    {
        $validatedAttributes = $this->validate();

        if ($this->questionImageUpload !== null) {
            $this->validate([
                'questionImageUpload' => ['required', 'image', 'mimes:jpg,png,webp'],
            ]);
            $s3 = $this->storeUploadedImage('question');
            $validatedAttributes['question_image_url'] = $s3;
        }
        
        if ($this->answerImageUpload !== null) {
            $this->validate([
                'answerImageUpload' => ['required', 'image', 'mimes:jpg,png,webp']
            ]);
            $s3 = $this->storeUploadedImage('answer');
            $validatedAttributes['answer_image_url'] = $s3;
        }

        $this->flashcard->update($validatedAttributes);

        return to_route('flashcards')->with('flash.banner', 'The flashcard has been saved!');
    }

    public function storeUploadedImage(string $type) : string
    {
        if ($type == 'question') {
            $url = $this->questionImageUpload->store('images/flashcards', 's3-public');
        } else {
            $url = $this->answerImageUpload->store('images/flashcards', 's3-public');
        }

        return (string) $url;
    }

    public function deleteFlashcard(int $id) : void
    {
        Flashcard::destroy($id);
    }
}
