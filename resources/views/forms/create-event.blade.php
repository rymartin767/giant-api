<form wire:submit.prevent="storeEvent" class="base-form">
    <div class="grid grid-cols-4 gap-3">
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.lazy="date" type="date" class="w-full rounded border-none bg-gray-200">
            @error('date')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.lazy="title" type="text" placeholder="Event Title" class="w-full rounded border-none bg-gray-200">
            @error('title')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.lazy="time" type="time" placeholder="Event Time H:i" class="w-full rounded border-none bg-gray-200">
            @error('time')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.lazy="location" type="text" placeholder="Event Location" class="w-full rounded border-none bg-gray-200">
            @error('location')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.lazy="web_url" type="text" placeholder="Web Url" class="w-full rounded border-none bg-gray-200">
            @error('web_url')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            @if ($photoUpload)
                Photo Preview:
                <img src="{{ $photoUpload->temporaryUrl() }}">
            @endif
            @if ($existingImageUrl)
                Photo Preview:
                <img src="{{ Storage::disk('s3-public')->url($existingImageUrl) }}">
            @endif
            <input type="file" wire:model="photoUpload">
            @error('photoUpload') 
                <div class="form-error">{{ $message }}</div> 
            @enderror
        </div>
        <div class="col-span-4">
            <div class="grid grid-cols-8 gap-2">
                @foreach ($images as $image)
                    <div wire:click="$set('existingImageUrl', '{{ $image }}')" class="col-span-1 cursor-pointer">
                        <img src="{{ Storage::disk('s3-public')->url($image) }}" alt="image">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-span-4 sm:col-span-1 pt-1">
            <button type="submit" class="w-full text-xs bg-blue-500 text-white font-semibold p-2 rounded-md shadow">Submit</button>
        </div>
    </div>
</form>