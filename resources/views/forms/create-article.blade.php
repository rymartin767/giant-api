<form wire:submit.prevent="storeArticle">
    <div class="grid grid-cols-4 gap-4">
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <select wire:model="category">
                <option value="">Choose Category...</option>
                @foreach (\App\Enums\ArticleCategory::cases() as $category)
                    <option value="{{ $category->value }}">{{ $category->getFullName() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4 bg-pink-300">
            <input wire:model="title" type="text">
        </div>
        <div class="col-span-4 bg-pink-300">
            <input wire:model="author" type="text">
        </div>
        <div class="col-span-4 bg-pink-300">
            <div wire:ignore>
                <textarea wire:model="story" name="story" id="story" class="rich-editor"></textarea>
            </div>
        </div>
        <div class="col-span-4 bg-pink-300">
            <input wire:model="web_url" type="text">
        </div>
        <div class="col-span-4 sm:col-span-1 bg-pink-300">
            <input type="file" wire:model="answerImageUpload">
        </div>
        <div class="col-span-4 sm:col-span-1 pt-1">
            <button type="submit" class="w-full text-xs bg-blue-500 text-white font-semibold p-2 rounded-md shadow">Submit</button>
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