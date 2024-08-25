@php
    $blocks = $template->getBlocks();
@endphp

<style>
    .template-container {
        @if ($template->getMaxWidth('unit') == 'percentage')
            max-width: {{ $template->getMaxWidth() == 0 ? 100 : $template->getMaxWidth() }}%;
        @else
            max-width: {{ $template->getMaxWidth() == 0 ? 640 : $template->getMaxWidth() }}px;
        @endif
        margin-left: auto;
        margin-right: auto;
        padding-left: {{ $template->getPadding('left.padding') }}rem;
        padding-right: {{ $template->getPadding('right.padding') }}rem;
    }



    @media (min-width: 640px) {
        .template-container {
            @if ($template->getMaxWidth('small.unit') === 'percentage')
                max-width: {{ $template->getMaxWidth('small.maxwidth') == 0 ? 100 : $template->getMaxWidth('small.maxwidth') }}%;
            @else
                max-width: {{ $template->getMaxWidth('small.maxwidth') == 0 ? 640 : $template->getMaxWidth('small.maxwidth') }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.small') }}rem;
            padding-right: {{ $template->getPadding('right.small') }}rem;
        }
    }

    @media (min-width: 768px) {
        .template-container {
            @if ($template->getMaxWidth('medium.unit') === 'percentage')
                max-width: {{ $template->getMaxWidth('medium.maxwidth') == 0 ? 100 : $template->getMaxWidth('medium.maxwidth') }}%;
            @else
                max-width: {{ $template->getMaxWidth('medium.maxwidth') == 0 ? 768 : $template->getMaxWidth('medium.maxwidth') }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.medium') }}rem;
            padding-right: {{ $template->getPadding('right.medium') }}rem;
        }
    }

    @media (min-width: 1024px) {
        .template-container {
            @if ($template->getMaxWidth('large.unit') === 'percentage')
                max-width: {{ $template->getMaxWidth('large.maxwidth') == 0 ? 100 : $template->getMaxWidth('large.maxwidth') }}%;
            @else
                max-width: {{ $template->getMaxWidth('large.maxwidth') == 0 ? 1024 : $template->getMaxWidth('large.maxwidth') }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.large') }}rem;
            padding-right: {{ $template->getPadding('right.large') }}rem;
        }
    }

    @media (min-width: 1280px) {
        .template-container {
            @if ($template->getMaxWidth('extra_large.unit') === 'percentage')
                max-width: {{ $template->getMaxWidth('extra_large.maxwidth') == 0 ? 100 : $template->getMaxWidth('extra_large.maxwidth') }}%;
            @else
                max-width: {{ $template->getMaxWidth('extra_large.maxwidth') == 0 ? 1280 : $template->getMaxWidth('extra_large.maxwidth') }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.extra_large') }}rem;
            padding-right: {{ $template->getPadding('right.extra_large') }}rem;
        }
    }

    @media (min-width: 1536px) {
        .template-container {
            @if ($template->getMaxWidth('2_extra_large.unit') === 'percentage')
                max-width: {{ $template->getMaxWidth('2_extra_large.maxwidth') == 0 ? 100 : $template->getMaxWidth('2_extra_large.maxwidth') }}%;
            @else
                max-width: {{ $template->getMaxWidth('2_extra_large.maxwidth') == 0 ? 1536 : $template->getMaxWidth('2_extra_large.maxwidth') }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.2_extra_large') }}rem;
            padding-right: {{ $template->getPadding('right.2_extra_large') }}rem;
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
