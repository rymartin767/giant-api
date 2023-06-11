<div x-data="{ showCard: true, showAnswer: false }" x-show="showCard" x-transition x-cloak id="flashcard" class="grid grid-cols-2">
    <div class="col-span-2 md:col-span-1">
        @livewire('image', ['imagePath' => 'images/flashcards/development/flashcard-test.jpg'])
    </div>
    <div class="col-span-2 md:col-span-1">
        <!-- QUESTION -->
        <div x-show="! showAnswer" class="flex bg-pink-100 min-h-full p-3">
            <div class="flex flex-col bg-yellow-300 grow p-1">
                <div class="grow bg-white">
                    {!! $flashcard->question !!}
                </div>
                <div>
                    <button @click="showAnswer = true" class="bg-gray-50 text-slate-400 text-center p-2 mt-1 rounded-md w-full">SHOW ANSWER</button>
                </div>
            </div>
        </div>
        <!-- ANSWER -->
        <div x-show="showAnswer" x-transition x-cloak class="flex bg-pink-500 min-h-full p-3">
            <div class="flex flex-col bg-yellow-300 grow p-1">
                <div class="grow bg-purple-400">
                    {!! $flashcard->answer !!}
                </div>
                <div>
                    <button @click="showCard = false" class="bg-yellow-300 text-white text-center p-2 mt-1 rounded-md w-full">DISMISS</button>
                </div>
            </div>
        </div>
    </div>
</div>