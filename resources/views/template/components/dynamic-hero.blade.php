@php
    $title = $block->getPageModel()->title;
    $subtitle = $block->getPageModel()->subtitle;
@endphp

<div class="{{ $block->getCustomCss() }}" style="{{ $block->getCustomStyle() }}">
    <div class="flex flex-col items-center justify-center h-full text-center p-4">
        <h1 class="text-4xl font-bold">{{ $title }}</h1>
        @if ($subtitle)
            <div class="text-xl mt-4">{{ $subtitle }}</div>
        @endif
    </div>
</div>
