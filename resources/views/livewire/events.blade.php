<div>
    <x-section class="max-w-5xl" title="Create Events">
        @include('forms.create-event')
    </x-section>

    <x-section class="max-w-5xl" title="Current Events">
        <div class="grid grid-cols-4 gap-3">
            @foreach ($events as $event)
                <div class="col-span-2 sm:col-span-1 p-3 bg-white rounded-md shadow-md">
                    <img src="{{ Storage::disk('s3-public')->url($event->image_url) }}" alt="image">
                    <div class="text-center mt-2">{{ $event->title }}</div>
                    <div class="text-xs text-center mb-1">{{ \Carbon\Carbon::parse($event->date)->format('m/d/Y') }}</div>
                    <div class="text-xs text-center mb-1">{{ $event->location ?? 'Remote/None' }}</div>
                    <button wire:click="deleteEvent({{$event->id}})" type="button" class="w-full text-xs bg-red-500 text-white font-semibold p-2 rounded-md shadow">DELETE</button>
                </div>
            @endforeach
        </div>
    </x-section>

    <x-section class="max-w-5xl" title="Manage Event Images">
        <x-flash message="Image Deleted"></x-flash>

        <div class="mt-8 grid grid-cols-4 gap-3">
            @foreach ($images as $image)
                <div class="col-span-2 sm:col-span-1 p-3 bg-white rounded-md shadow-md">
                    <img src="{{ Storage::disk('s3-public')->url($image) }}" alt="image">
                    <button wire:click="deleteImage('{{$image}}')" type="button" class="w-full text-xs bg-red-500 text-white font-semibold p-2 rounded-md shadow mt-2">DELETE</button>
                </div>
            @endforeach
        </div>
    </x-section>
</div>