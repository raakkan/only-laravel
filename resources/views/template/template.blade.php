@php
    $blocks = $template->getBlocks();
@endphp

<style>
    .template-container {
        @if ($template->maxwidthUnit === 'percentage')
            max-width: {{ $template->maxwidth == 0 ? 100 : $template->maxwidth }}%;
        @else
            max-width: {{ $template->maxwidth == 0 ? 640 : $template->maxwidth }}px;
        @endif
        margin-left: auto;
        margin-right: auto;
        padding-left: {{ $template->padding }}rem;
        padding-right: {{ $template->padding }}rem;
    }

    @media (min-width: 640px) {
        .template-container {
            @if ($template->maxwidthSmallUnit === 'percentage')
                max-width: {{ $template->maxwidthSmall == 0 ? 100 : $template->maxwidthSmall }}%;
            @else
                max-width: {{ $template->maxwidthSmall == 0 ? 640 : $template->maxwidthSmall }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->paddingSmall }}rem;
            padding-right: {{ $template->paddingSmall }}rem;
        }
    }

    @media (min-width: 768px) {
        .template-container {
            @if ($template->maxwidthMediumUnit === 'percentage')
                max-width: {{ $template->maxwidthMedium == 0 ? 100 : $template->maxwidthMedium }}%;
            @else
                max-width: {{ $template->maxwidthMedium == 0 ? 768 : $template->maxwidthMedium }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->paddingMedium }}rem;
            padding-right: {{ $template->paddingMedium }}rem;
        }
    }

    @media (min-width: 1024px) {
        .template-container {
            @if ($template->maxwidthLargeUnit === 'percentage')
                max-width: {{ $template->maxwidthLarge == 0 ? 100 : $template->maxwidthLarge }}%;
            @else
                max-width: {{ $template->maxwidthLarge == 0 ? 1024 : $template->maxwidthLarge }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->paddingLarge }}rem;
            padding-right: {{ $template->paddingLarge }}rem;
        }
    }

    @media (min-width: 1280px) {
        .template-container {
            @if ($template->maxwidthExtraLargeUnit === 'percentage')
                max-width: {{ $template->maxwidthExtraLarge == 0 ? 100 : $template->maxwidthExtraLarge }}%;
            @else
                max-width: {{ $template->maxwidthExtraLarge == 0 ? 1280 : $template->maxwidthExtraLarge }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->paddingExtraLarge }}rem;
            padding-right: {{ $template->paddingExtraLarge }}rem;
        }
    }

    @media (min-width: 1536px) {
        .template-container {
            @if ($template->maxwidth2ExtraLargeUnit === 'percentage')
                max-width: {{ $template->maxwidth2ExtraLarge == 0 ? 100 : $template->maxwidth2ExtraLarge }}%;
            @else
                max-width: {{ $template->maxwidth2ExtraLarge == 0 ? 1536 : $template->maxwidth2ExtraLarge }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->padding2ExtraLarge }}rem;
            padding-right: {{ $template->padding2ExtraLarge }}rem;
        }
    }
</style>

<body
    style="
    width: 100%; 
    height: 100%; 
    background-color: {{ $template->backgroundColor }}; 
    color: {{ $template->textColor }};
    font-family: {{ $template->fontFamily ?? 'Arial, Helvetica, sans-serif' }}; 
    font-size: {{ $template->fontSize }}rem; 
    line-height: {{ $template->lineHeight }}rem;
    ">
    @foreach ($blocks as $block)
        {{ $block->render() }}
    @endforeach
</body>
