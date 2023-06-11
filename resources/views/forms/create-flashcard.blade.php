<form wire:submit.prevent="storeFlashcard" class="base-form">
    <div class="grid grid-cols-4 gap-4">
        <div class="col-span-4 sm:col-span-2">
            <select wire:model="category">
                <option value="">Choose Category...</option>
                @foreach (\App\Enums\FlashcardCategory::cases() as $category)
                    <option value="{{ $category->value }}">{{ $category->getFullName() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4 sm:col-span-2">
            <select wire:model="reference">
                <option value="">Choose Reference...</option>
                @foreach (\App\Enums\FlashcardReference::cases() as $reference)
                    <option value="{{ $reference->value }}">{{ $reference->getFullName() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4 sm:col-span-2">
            <select wire:model="eicas_type">
                <option value="">Choose EICAS Type...</option>
                @foreach (\App\Enums\FlashcardEicasType::cases() as $type)
                    <option value="{{ $type->value }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4 sm:col-span-2">
            <input wire:model="eicas_message" type="text" placeholder="Enter exact EICAS message">
        </div>
        <div class="col-span-4">
            <div wire:ignore>
                <textarea wire:model="question" name="question" id="question" class="rich-editor"></textarea>
            </div>
        </div>
        <div class="col-span-4">
            <div wire:ignore>
                <textarea wire:model="answer" name="answer" id="answer" class="rich-editor"></textarea>
            </div>
        </div>
        <div class="col-span-4">
            <div class="grid grid-cols-3">
                <div class="col-span-3 sm:col-span-1">
                    <input type="file" wire:model="questionImageUpload">
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <input type="file" wire:model="answerImageUpload">
                </div>
                <div class="col-span-3 sm:col-span-1 pb-1">
                    <button type="submit" class="w-full text-xs bg-blue-500 text-white font-semibold p-2 rounded-md shadow">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
@endpush

<script>
    ClassicEditor
        .create(document.querySelector('#question'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('question', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#answer'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
                @this.set('answer', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>