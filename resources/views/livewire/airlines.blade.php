<div>
    <x-section class="max-w-5xl" title="Create Airlines">
        @include('forms.create-airline')
    </x-section>

    <x-section class="max-w-5xl" title="Current Airlines">
        <div class="grid grid-cols-4 gap-3">
            @foreach ($airlines as $airline)
                <div class="col-span-2 sm:col-span-1 p-3 bg-white rounded-md shadow-md">
                    <div class="text-center mt-2">{{ $airline->name }}</div>
                    <div class="text-xs text-center mb-1">{{ $airline->icao }}</div>
                    <div class="text-xs text-center mb-1">
                        @if ($airline->scales->isNotEmpty())
                            <div>{{ $airline->scales->count() . ' Pay Scale Found for ' . $airline->icao}}</div>
                        @else
                            <div>{{ 'No Pay Rates Found for '  . $airline->icao }}</div>
                        @endif
                    </div>
                    <div class="flex border-t border-gray-600 py-2 justify-center">
                        @if ($airline->hasAwsScales())
                            <x-button type="button" aria-disabled="true" disabled>Truncate + Reload</x-button>
                        @else
                            <x-button type="button" aria-disabled="true" disabled class=" bg-red-500">No AWS Scales Found!</x-button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </x-section>
</div>