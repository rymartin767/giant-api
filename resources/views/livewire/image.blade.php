<div wire:init="loadImage">
    <div class="flex flex-col">
        <div wire:loading>loading...</div>
        <div wire:loading.remove>
            <img src="{{ $url }}" alt="" loading="lazy">
        </div>         
    </div>
</div>
