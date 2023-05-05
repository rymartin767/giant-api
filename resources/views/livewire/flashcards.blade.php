<div>
    <x-section class="max-w-5xl" title="Create Flashcards">
        @include('forms.create-flashcard')
    </x-section>

    <x-section class="max-w-5xl" title="Flashcard Index">
        <div class="bg-white p-3 mb-4">
            <select wire:model="showByCategory">
                <option value="Choose Category" selected></option>
                @foreach (\App\Enums\FlashcardCategory::cases() as $category)
                    <option value="{{ $category->value }}">{{ $category->getFullName() }}</option>
                @endforeach
            </select>
        </div>
        <x-table class="w-full">
            <x-slot:head>
                <x-table.th>CATEGORY</x-table>
                <x-table.th>QUESTION</x-table>
                <x-table.th>QUESTION IMG URL</x-table>
                <x-table.th>ANSWER IMG URL</x-table>
            </x-slot:head>
            <x-slot:body>
                @foreach ($flashcards as $flashcard)
                    <tr>
                        <x-table.td>{{ $flashcard->category->getFullName() }}</x-table>
                        <x-table.td>{!! str($flashcard->question)->limit(50) !!}</x-table>
                        <x-table.td>
                            @if (! $flashcard->question_image_url === null)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6 fill-current text-green-500"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6 fill-current text-red-500"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                            @endif
                        </x-table>
                        <x-table.td>
                            @if (! $flashcard->answer_image_url === null)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6 fill-current text-green-500"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6 fill-current text-red-500"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                            @endif
                        </x-table>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>
    </x-section>

    <x-section class="max-w-5xl" title="Flashcard Preview">
        @livewire('image', ['imagePath' => 'images/flashcards/development/flashcard-test.jpg'])
    </x-section>

    <x-section class="max-w-5xl" title="API Endpoints">
        <x-api-list>
            <x-slot:items>
                <x-api-li type="Collection Response" params="category" endpoint="v1/flashcards">
                    <pre><x-torchlight-code language='php' contents='views/torchlight/api/flashcards/collection-response.blade.php'/></pre>
                </x-api-li>
            </x-slot:items>
        </x-api-list>
    
        <x-api-list>
            <x-slot:items>
                <x-api-li type="Collection Response: Category Parameter" params="category" endpoint="v1/flashcards?category=6">
                    <pre><x-torchlight-code language='php' contents='views/torchlight/api/flashcards/collection-response.blade.php'/></pre>
                </x-api-li>
            </x-slot:items>
        </x-api-list>
    </x-section>
</div>