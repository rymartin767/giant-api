<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportRedirects\Redirector;

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

    protected function rules(): array
    {
        return (new EventRequest())->rules();
    }

    public function render() : View
    {
        return view('livewire.events', [
            'events' => Event::all(),
            'images' => Storage::disk('s3-public')->allFiles('images/events')
        ]);
    }

    public function storeEvent() : Redirector
    {
        $this->validate(['photoUpload' => ['present', 'image', 'nullable']]);

        $attributes = $this->validate();

        $attributes['user_id'] = Auth::id();
        $attributes['image_url'] = $this->existingImageUrl ?? $this->storeUploadedImage();

        Event::create($attributes);
        $this->reset();

        return to_route('events')->with('flash.banner', 'Event successfully created!');
    }

    public function deleteEvent($id) : void
    {
        Event::destroy($id);
        $this->dispatch('flash-message', []);
    }

    public function storeUploadedImage() : String
    {
        $url = $this->photoUpload->store('images/events', 's3-public');
        return (string) $url;
    }

    public function deleteImage($url)
    {
        // Storage::disk('s3-public')->delete($url);
        $this->dispatch('flash-message', []);
    }
}
