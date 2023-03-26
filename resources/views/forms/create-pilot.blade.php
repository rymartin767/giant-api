<form wire:submit.prevent="storePilots">
    <div class="px-4 py-2 space-y-2">
        <div class="flex items-center space-x-3">
            <select wire:model="selectedYear" class="bg-gray-100 rounded-full border-none">
                <option value="" selected>Select Year</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023" selected>2023</option>
            </select>
            <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="text-blue-600" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
        <select wire:model="selectedAwsFilePath" class="w-full bg-gray-100 rounded-full border-none">
            <option value="">Select One...</option>
            @foreach($files as $file)
                <option value="{{ $file }}">{{ $file }}</option>
            @endforeach
        </select>
    </div>
    <div class="mt-4">
        <div class="flex items-center justify-end px-4 py-3 bg-gray-100">
            @isset($status)
                <div x-data="{ shown: false, timeout: null }" x-init="() => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 5000); }" x-show.transition.opacity.out.duration.1500ms="shown" class="text-sm text-green-400 mr-6 pt-1">{{ $status }}</div>
            @endisset
            <button type="submit" class="w-full bg-white text-gray-500 border border-blue-400 rounded px-3 py-2">
                <svg wire:loading wire:target="submitForm" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Submit Form</span>
            <button>
        </div>
    </div>
</form>