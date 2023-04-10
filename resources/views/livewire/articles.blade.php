<div>
    <x-section class="max-w-5xl" title="Create Articles">
        @include('forms.create-article')
    </x-section>

    <x-section class="max-w-5xl" title="Recent Articles">
        <div class="max-w-5xl">
            <x-table class="w-full" title="Article Index">
                <x-slot:head>
                    <x-table.th>Date</x-table.th>
                    <x-table.th>Title</x-table.th>
                    <x-table.th>Author</x-table.th>
                    <x-table.th>Category</x-table.th>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($articles as $article)
                        <tr>
                            <x-table.td>{{ Carbon\Carbon::parse($article->date)->format('m/d/Y') }}</x-table.td>
                            <x-table.td>{{ str($article->title)->limit(50) }}</x-table.td>
                            <x-table.td>{{ $article->author }}</x-table.td>
                            <x-table.td>{{ $article->category->getFullName() }}</x-table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-table.td>No Articles Saved!</x-table.td>
                            <x-table.td>No Articles Saved!</x-table.td>
                            <x-table.td>No Articles Saved!</x-table.td>
                            <x-table.td>No Articles Saved!</x-table.td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </x-section>
</div>