<div>
    <x-section class="max-w-5xl" title="Create Flashcards">
        @include('forms.create-flashcard')
    </x-section>

    <x-section class="max-w-5xl" title="Flashcard Index">
        <div class="flex flex-col space-y-4 bg-yellow-400">
            @foreach ($flashcards->groupBy(fn($flashcard) => $flashcard->category->getFullName()) as $category => $cards)
                <div class="rounded-md shadow-md overflow-hidden">
                    <div class="w-full p-2 bg-slate-600 text-2xl uppercase text-white">{{ $category }}</div>
                    <div class="flex flex-col bg-slate-300 p-3">
                        @foreach ($cards as $card)
                            <div class="flex flex-row bg-slate-300 text-white text-xl">
                                <a href="{{ $card->path() }}" class="flex-1">
                                    <div>{!! $card->question !!}</div>
                                </a>
                                <button wire:click="deleteFlashcard({{ $card->id }})" class="bg-slate-600 p-2 rounded-md">DELETE</button>
                            </div>
                        @endforeach
                        <div class="flex flex-row space-x-6 text-xs italic">
                            <div>Has Question Image: {{ $card->question_image_url ? 'True' : 'False' }}</div>
                            <div>Has Answer Image: {{ $card->answer_image_url ? 'True' : 'False' }}</div>
                            <div>Correct Count: 0</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-section>
</div>