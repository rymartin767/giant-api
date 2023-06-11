<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Flashcard;
use Livewire\Component;

class Flashcards extends Component
{
    public $loaded = false;
    public $status;

    public function render()
    {
        return view('livewire.dashboard.flashcards');
    }

    public function initLoading() : void
    {
        $this->status = 'Flashcard Count: ' . Flashcard::count();

        $this->loaded = true;
    }
}
