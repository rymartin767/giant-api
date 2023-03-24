<div>
    <x-section class="max-w-5xl" title="Create Articles">
        form here
    </x-section>

    <x-section class="max-w-5xl" title="Recent Articles">
        <div class="grid grid-cols-4 gap-3">
            @forelse ($articles as $article)
                <div class="col-span-2 sm:col-span-1 p-3 bg-white rounded-md shadow-md">
                    {{ $article->title }}
                </div>
            @empty  
                <div>
                    Article Library is empty.
                </div>
            @endforelse
        </div>
    </x-section>
</div>