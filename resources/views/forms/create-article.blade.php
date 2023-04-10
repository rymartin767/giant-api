<form wire:submit.prevent="storeArticle" class="base-form">
    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-3 sm:col-span-1">
            <input type="date" wire:model="date" class="w-full">
        </div>
        <div class="col-span-3 sm:col-span-1">
            <input wire:model="title" type="text" class="w-full" placeholder="Article Title">
        </div>
        <div class="col-span-3 sm:col-span-1">
            <input wire:model="author" type="text" class="w-full" placeholder="Article Author">
        </div>
        <div class="col-span-3">
            <div wire:ignore>
                <textarea wire:model="story" name="story" id="story" class="rich-editor"></textarea>
            </div>
        </div>
        <div class="col-span-3 sm:col-span-1">
            <select wire:model="category" class="w-full">
                <option value="">Choose Category...</option>
                @foreach (\App\Enums\ArticleCategory::cases() as $category)
                    <option value="{{ $category->value }}">{{ $category->getFullName() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-3 sm:col-span-1">
            <input wire:model="web_url" type="text" class="w-full" placeholder="Web URL">
        </div>
        <div class="col-span-3 sm:col-span-1 bg-white flex items-center py-2">
            <input type="file" wire:model="answerImageUpload">
        </div>
        <div class="col-span-4 sm:col-span-1">
            <x-button type="submit" class="">Submit</x-button>
        </div>
    </div>
    
</form>

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
@endpush

<script>
    ClassicEditor
        .create(document.querySelector('#story'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('story', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>