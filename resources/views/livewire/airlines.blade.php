<div>
    <x-section class="max-w-5xl" title="Create Airlines">
        @include('forms.create-airline')
    </x-section>

    <x-section class="max-w-5xl" title="Current Airlines">
        
        <x-flash message="Airline Created Successfully!"></x-flash>

        <div class="grid grid-cols-4 gap-3">
            @foreach ($airlines as $airline)
                <div class="col-span-2 sm:col-span-1 p-3 bg-white rounded-md shadow-md">
                    <div class="text-center mt-2">{{ $airline->name }}</div>
                    <div class="text-xs text-center mb-1">{{ $airline->icao }}</div>
                </div>
            @endforeach
        </div>
    </x-section>
</div>