<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Events extends Component
{
    use WithFileUploads;

    // EVENT FORMDATA
    public $title;
    public $date;
    public $time;
    public $location;
    public $web_url = null;

    public $photoUpload;
    public $existingImageUrl;

    public function render()
    {
        return view('livewire.events', [
            'events' => Event::all(),
            'images' => Storage::disk('s3-public')->allFiles('images/events')
        ]);
    }

    public function storeEvent()
    {
        $this->validate(['photoUpload' => ['present', 'image', 'nullable']]);

        $attributes = $this->validate([
            'title' => ['required', 'string', 'min:3', 'max:50'],
            'date' => ['required', 'date'],
            'time' => ['present', 'date_format:H:i', 'nullable'],
            'location' => ['present', 'string', 'min:5', 'max:50', 'nullable'],
            'web_url' => ['present', 'string', 'min:8', 'max:100', 'starts_with:https://', 'nullable']
        ]);

        $attributes['user_id'] = Auth::id();
        $attributes['image_url'] = $this->existingImageUrl ?? $this->storeUploadedImage();

        Event::create($attributes);
        $this->reset();
    }

    public function deleteEvent($id)
    {
        Event::destroy($id);
        $this->dispatchBrowserEvent('flash-message', []);
    }

    public function storeUploadedImage() : String
    {
        $url = $this->photoUpload->store('images/events', 's3-public');
        return (string) $url;
    }

    public function deleteImage($url)
    {
        // Storage::disk('s3-public')->delete($url);
        $this->dispatchBrowserEvent('flash-message', []);
    }
}
