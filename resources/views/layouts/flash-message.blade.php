@if (session()->has('message'))
    <div x-data="{ show:true }" x-init()="setTimeout(() => show = false, 3000)">
        <div class="fixed z-50 bottom-8 right-8 bg-black w-auto p-4 rounded-full text-white" x-show="show" transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0 transform scale-x-0 -translate-x-1/2" x-transition:enter-end="opacity-100 transform scale-x-100 translate-x-0" x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="opacity-100 transform scale-x-100 translate-x-0" x-transition:leave-end="opacity-0 transform scale-x-0 -translate-x-1/2">
            {{ session('message') }}
        </div>
    </div>
@endif