@php
    $image = $block->getImage();
    $altText = $block->getAltText();
    $imagePosition = $block->getImagePosition();
@endphp

<section class="{{ $block->getName() }} {{ $block->getCustomCss() }}">
    <div class="container mx-auto px-4">
        <div
            class="image-container 
            @if ($imagePosition === 'left') flex justify-start
            @elseif($imagePosition === 'right')
                flex justify-end
            @else
                flex justify-center @endif
        ">
            @if ($image)
                <img src="{{ $block->getImageUrl() }}" alt="{{ $altText }}" class="max-w-full h-auto">
            @else
                <div class="placeholder-image w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No image uploaded</span>
                </div>
            @endif
        </div>
    </div>
</section>
