<form wire:submit="storeArticle" class="base-form">
    <div class="grid grid-cols-3 gap-3">
        <div class="col-span-3 sm:col-span-1">
            <input type="date" wire:model.live="date" class="w-full">
            @error('date')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-3 sm:col-span-1">
            <input wire:model.live="title" type="text" class="w-full" placeholder="Article Title">
            @error('title')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-3 sm:col-span-1">
            <input wire:model.live="author" type="text" class="w-full" placeholder="Article Author">
            @error('author')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-3">
            <div wire:ignore>
                <textarea wire:model.live="story" name="story" id="story" class="rich-editor"></textarea>
                @error('story')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-span-3 sm:col-span-1">
            <select wire:model.live="category" class="w-full">
                <option value="">Choose Category...</option>
                @foreach (\App\Enums\ArticleCategory::cases() as $category)
                    <option value="{{ $category->value }}">{{ $category->getFullName() }}</option>
                @endforeach
            </select>
            @error('category')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-3 sm:col-span-1">
            <input wire:model.live="web_url" type="text" class="w-full" placeholder="Web URL">
            @error('web_url')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-span-3 sm:col-span-1 bg-white flex items-center py-2">
            <input type="file" wire:model.live="answerImageUpload">
            @error('file')
                <div class="form-error">{{ $message }}</div>
            @enderror
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