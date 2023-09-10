<form wire:submit="storeAwards" class="base-form">
    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-3">
            @isset($status)
                <div x-data="{ shown: false, timeout: null }" x-init="() => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 5000); }" x-show.transition.opacity.out.duration.1500ms="shown" class="text-sm text-green-400 mr-6 pt-1">{{ $status }}</div>
            @endisset
        </div>
        <div class="col-span-3 sm:col-span-1">
            <select wire:model.live="selectedYear">
                <option value="" selected>Select Year</option>
                <option value="2023">2023</option>
            </select>
        </div>
        <div class="col-span-3 sm:col-span-1">
            <select wire:model.live="selectedAwsFilePath">
                <option value="">Select One...</option>
                @foreach($files as $file)
                    <option value="{{ $file }}">{{ $file }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-3 sm:col-span-1">
            <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="text-blue-600" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
        <div class="col-span-3">
            <x-button type="submit">
                <svg wire:loading wire:target="submitForm" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Submit Form</span>
            </x-button>
        </div>
    </div>
</form>