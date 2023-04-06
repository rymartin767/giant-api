<div>
    <x-section class="max-w-5xl" title="Create Articles">
        @include('forms.create-article')
    </x-section>

    <x-section class="max-w-5xl" title="Recent Articles">
        <div class="max-w-5xl">
            <x-table class="w-full" title="Article Index">
                <x-slot:head>
                    <x-table.th>Date</x-table>
                    <x-table.th>Title</x-table>
                    <x-table.th>Author</x-table>
                    <x-table.th>Category</x-table>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($articles as $article)
                        <x-table.td>{{ Carbon\Carbon::parse($article->date)->format('m/d/Y') }}</x-table>
                        <x-table.td>{{ str($article->title)->limit(50) }}</x-table>
                        <x-table.td>{{ $article->author }}</x-table>
                        <x-table.td>{{ $article->category->getFullName() }}</x-table>
                    @empty
                        empty
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </x-section>
</div>