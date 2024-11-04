@php
    $title = $block->getPageModel()->title;
    $subtitle = $block->getPageModel()->subtitle;
    $heroImage = $block->getSetting('hero.image');
    $heroStyles = '';
    if ($heroImage) {
        $heroStyles .= sprintf(
            'background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url("%s"); background-size: cover; background-position: center;',
            $heroImage,
        );
    }
@endphp

<div class="{{ $block->getCustomCss() }}" style="{{ $block->getCustomStyle() }} {{ $heroStyles }}">
    <div class="flex flex-col items-center justify-center h-full text-center p-4">
        <h1 class="text-4xl font-bold">{{ $title }}</h1>
        @if ($subtitle)
            <div class="text-xl mt-4">{{ $subtitle }}</div>
        @endif
    </div>
</div>
