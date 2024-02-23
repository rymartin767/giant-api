<x-section class="max-w-5xl" title="Edit Flashcard">
    <form wire:submit="updateFlashcard" class="base-form">
        <div class="grid grid-cols-4 gap-4">
            <div class="col-span-4 sm:col-span-2">
                <select wire:model.live="category">
                    <option value="{{ $flashcard->category }}">{{ $flashcard->category }}</option>
                    @foreach (\App\Enums\FlashcardCategory::cases() as $category)
                    <option value="{{ $category->value }}">{{ $category->getLabel() }}</option>
                    @endforeach
                </select>
                @error('category')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-4 sm:col-span-2">
                <select wire:model.live="reference">
                    <option value="{{ $flashcard->reference }}">{{ $flashcard->reference }}</option>
                    @foreach (\App\Enums\FlashcardReference::cases() as $reference)
                        <option value="{{ $reference->value }}">{{ $reference->getLabel() }}</option>
                    @endforeach
                </select>
                @error('reference')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-4 sm:col-span-2">
                <select wire:model.live="eicas_type">
                    <option value="{{ $flashcard->eicas_type }}">{{ $flashcard->eicas_type }}</option>
                    @foreach (\App\Enums\FlashcardEicasType::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('eicas_type')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-4 sm:col-span-2">
                <input wire:model.live="eicas_message" type="text" value="{{ $eicas_message }}">
                @error('eicas_message')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-4">
                <div wire:ignore>
                    <textarea wire:model.live="question" name="question" id="question" class="rich-editor">{{ $flashcard->question }}</textarea>
                </div>
                @error('question')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-4">
                <div wire:ignore>
                    <textarea wire:model.live="answer" name="answer" id="answer" class="rich-editor">{{ $flashcard->answer }}</textarea>
                </div>
                @error('answer')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-4">
                <div class="grid grid-cols-3">
                    <div class="col-span-3 sm:col-span-1">
                        <input type="file" wire:model.live="questionImageUpload">
                        @error('questionImageUpload')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <input type="file" wire:model.live="answerImageUpload">
                        @error('answerImageUpload')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-span-3 sm:col-span-1 pb-1">
                        <button type="submit" class="w-full text-xs bg-blue-500 text-white font-semibold p-2 rounded-md shadow">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="grid grid-cols-3 gap-3 mt-3">
        @if ($flashcard->question_image_url != null)
            <div class="col-span-1 flex flex-col space-y-2">
                <img src="{{ Storage::disk('s3-public')->url($flashcard->question_image_url) }}" alt="">
                <x-button wire:click="deleteUploadedImage('question')" type="button" class="bg-red-500">DELETE QUESTION IMAGE</x-button>
            </div>
        @endif

        @if ($flashcard->answer_image_url != null)
            <div class="col-span-1 flex flex-col space-y-2">
                <img src="{{ Storage::disk('s3-public')->url($flashcard->answer_image_url) }}" alt="">
                <x-button wire:click="deleteUploadedImage('answer')" type="button" class="bg-red-500">DELETE ANSWER IMAGE</x-button>
            </div>
        @endif

        <div class="col-span-1">
            <div class="flex flex-col">
                <x-button wire:click="deleteFlashcard({{ $flashcard->id}})" type="button" class="bg-red-500">DELETE FLASHCARD</x-button>
            </div>
        </div>
    </div>

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
</x-section>