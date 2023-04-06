<div {{ $attributes->merge(['class' => 'mx-auto mb-8']) }}>
    <div class="mb-6">
        <div class="border-l-4 border-green-500 pl-3">
                <div class="font-black text-4xl">{{ $title ?? 'NO TITLE' }}</div>
        </div>
    </div>

    <div>
        {{ $slot }}
    </div>
</div>