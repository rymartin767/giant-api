<form wire:submit="storeAirline" class="base-form">
    <div class="grid grid-cols-4 gap-4">
        <div class="col-span-4 sm:col-span-1">
            <select wire:model.live="sector" class="w-full">
                <option value="">Choose Sector...</option>
                @foreach (\App\Enums\AirlineSector::cases() as $sector)
                    <option value="{{ $sector->value }}">{{ $sector->name }}</option>
                @endforeach
            </select>
            @error('sector')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.blur="name" type="text" placeholder="Airline Name">
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.blur="icao" type="text" maxlength="4" class="w-full" placeholder="ICAO Code">
            @error('icao')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.blur="iata" type="text" maxlength="2" class="w-full" placeholder="IATA Code">
            @error('iata')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <select wire:model.live="union" class="w-full">
                <option value="">Choose Union...</option>
                @foreach (\App\Enums\AirlineUnion::cases() as $union)
                    <option value="{{ $union->value }}">{{ $union->name }}</option>
                @endforeach
            </select>
            @error('union')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.blur="pilot_count" type="number" maxlength="5" class="w-full" placeholder="Pilot Count">
            @error('pilot_count')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <select wire:model.live="is_hiring" class="w-full">
                <option value="">Hiring Status...</option>
                <option value="1">True</option>
                <option value="0">False</option>
            </select>
            @error('is_hiring')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1">
            <input wire:model.blur="web_url" type="text" class="w-full" placeholder="Website Url">
            @error('web_url')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-4 sm:col-span-1 pt-1">
            <x-button type="submit" class="w-full">
                <div class="w-full">submit</div>
            </x-button>
        </div>
    </div>
</form>