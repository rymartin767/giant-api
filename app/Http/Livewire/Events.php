<?php

namespace App\Http\Livewire;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Livewire\Component;
use Illuminate\View\View;
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

    public function storeEvent() : void
    {
        $this->validate(['photoUpload' => ['present', 'image', 'nullable']]);

        $attributes = $this->validate();

        $attributes['user_id'] = Auth::id();
        $attributes['image_url'] = $this->existingImageUrl ?? $this->storeUploadedImage();

        Event::create($attributes);
        $this->reset();
    }

    public function deleteEvent($id) : void
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
