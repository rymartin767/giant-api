<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-3 gap-2">
                <div class="col-span-3 mb-4 p-3 bg-white rounded">
                    <div class="flex flex-row justify-around">
                        <div>API v1.0</div>
                        <div>PHP v{{ PHP_VERSION }}</div>
                        <div>Laravel v{{ app()->version() }}</div>
                    </div>
                </div>
                
                <livewire:dashboard.airlines lazy />
                <livewire:dashboard.articles lazy />
                <livewire:dashboard.awards lazy />
                <livewire:dashboard.events lazy />
                <livewire:dashboard.flashcards lazy />
                <livewire:dashboard.pilots lazy />
                <livewire:dashboard.staffing lazy />

            </div>
        </div>
    </div>
</div>