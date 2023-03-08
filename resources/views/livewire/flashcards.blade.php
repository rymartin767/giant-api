<div>
    <x-section class="max-w-5xl" title="Create Flashcards">
        @include('forms.create-flashcard')
    </x-section>

    <x-section class="max-w-5xl" title="Flashcard Index">
        <div class="flex flex-col space-y-4 bg-yellow-500 py-8">
            @foreach ($flashcards->groupBy(fn($flashcard) => $flashcard->category->getFullName()) as $category => $cards)
                <div class="p-3 bg-green-400 rounded-md shadow-md">
                    <div class="w-full bg-purple-400">{{ $category }}</div>
                    <div class="flex flex-col space-y-3 bg-orange-400 p-3">
                        @foreach ($cards as $card)
                            <div class="flex flex-row bg-blue-400 py-2">
                                <a href="{{ $card->path() }}" class="flex-1">
                                    <div>{!! $card->question !!}</div>
                                </a>
                                <button wire:click="deleteFlashcard({{ $card->id }})">DELETE</button>
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