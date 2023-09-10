<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Image extends Component
{
    public $imagePath;
    public $url;

    public function render()
    {
        return view('livewire.image');
    }

    public function loadImage() : void
    {
        $this->url = Storage::disk('s3-public')->url($this->imagePath);
    }
}
