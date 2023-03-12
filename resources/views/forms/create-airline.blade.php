<form wire:submit.prevent="storeAirline">
    <div class="grid grid-cols-4 gap-4">
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <select wire:model="sector" class="w-full">
                <option value="">Choose Sector...</option>
                @foreach (\App\Enums\AirlineSector::cases() as $sector)
                    <option value="{{ $sector->value }}">{{ $sector->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <input wire:model.lazy="name" type="text" class="w-full" placeholder="Airline Name">
        </div>
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <input wire:model.lazy="icao" type="text" maxlength="4" class="w-full" placeholder="ICAO Code">
        </div>
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <input wire:model.lazy="iata" type="text" maxlength="2" class="w-full" placeholder="IATA Code">
        </div>
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <select wire:model="union" class="w-full">
                <option value="">Choose Union...</option>
                @foreach (\App\Enums\AirlineUnion::cases() as $union)
                    <option value="{{ $union->value }}">{{ $union->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <input wire:model.lazy="pilot_count" type="number" maxlength="5" class="w-full" placeholder="Pilot Count">
        </div>
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <select wire:model="is_hiring" class="w-full">
                <option value="">Hiring Status...</option>
                <option value="1">True</option>
                <option value="0">False</option>
            </select>
        </div>
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <input wire:model.lazy="web_url" type="text" class="w-full" placeholder="Website Url">
        </div>
        <div class="col-span-4 sm:col-span-1 pt-1">
            <x-button type="submit" class="w-full">
                <div class="w-full">submit</div>
            </x-button>
        </div>
    </div>
</form>