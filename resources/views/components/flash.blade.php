<div x-data="{ show: false }" @flash-message.window="show = true; setTimeout(() => show = false, 3000)">
    <div class="text-3xl bg-green-400 text-white px-4 py-2" x-show="show" transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0 transform scale-x-0 -translate-x-1/2" x-transition:enter-end="opacity-100 transform scale-x-100 translate-x-0" x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="opacity-100 transform scale-x-100 translate-x-0" x-transition:leave-end="opacity-0 transform scale-x-0 -translate-x-1/2">
        {{ $message }}
    </div>
</div>