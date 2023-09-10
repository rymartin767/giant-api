<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Flashcard;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use App\Http\Requests\FlashcardRequest;
use Livewire\Features\SupportRedirects\Redirector;

class Flashcards extends Component
{
    use WithFileUploads;

    // FORMDATA
    public $category;
    public $question;
    public $answer;
    public $reference;
    public $eicas_type = null;
    public $eicas_message = null;

    public $questionImageUpload;
    public $answerImageUpload;

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

        Flashcard::create($validatedAttributes);

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
}
