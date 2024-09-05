@php
    $blocks = $template->getBlocks();
@endphp

<style>
    .template-container {
        max-width: {{ $template->getMaxWidth() == 0 ? 640 : $template->getMaxWidth() }}{{ $template->getMaxWidth('unit') ? $template->getMaxWidth('unit') : '%' }};
        margin-left: auto;
        margin-right: auto;
        padding-left: {{ $template->getPadding('left.padding') }}rem;
        padding-right: {{ $template->getPadding('right.padding') }}rem;
    }

    @media (min-width: 640px) {
        .template-container {
            max-width: {{ $template->getMaxWidth('small.maxwidth') == 0 ? 640 : $template->getMaxWidth('small.maxwidth') }}{{ $template->getMaxWidth('small.unit') ? $template->getMaxWidth('small.unit') : 'px' }};
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.small') }}rem;
            padding-right: {{ $template->getPadding('right.small') }}rem;
        }
    }

    @media (min-width: 768px) {
        .template-container {
            max-width: {{ $template->getMaxWidth('medium.maxwidth') == 0 ? 768 : $template->getMaxWidth('medium.maxwidth') }}{{ $template->getMaxWidth('medium.unit') ? $template->getMaxWidth('medium.unit') : 'px' }};
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.medium') }}rem;
            padding-right: {{ $template->getPadding('right.medium') }}rem;
        }
    }

    @media (min-width: 1024px) {
        .template-container {
            max-width: {{ $template->getMaxWidth('large.maxwidth') == 0 ? 1024 : $template->getMaxWidth('large.maxwidth') }}{{ $template->getMaxWidth('large.unit') ? $template->getMaxWidth('large.unit') : 'px' }};
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.large') }}rem;
            padding-right: {{ $template->getPadding('right.large') }}rem;
        }
    }

    @media (min-width: 1280px) {
        .template-container {
            max-width: {{ $template->getMaxWidth('extra_large.maxwidth') == 0 ? 1280 : $template->getMaxWidth('extra_large.maxwidth') }}{{ $template->getMaxWidth('extra_large.unit') ? $template->getMaxWidth('extra_large.unit') : 'px' }};
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $template->getPadding('left.extra_large') }}rem;
            padding-right: {{ $template->getPadding('right.extra_large') }}rem;
        }
    }

    @media (min-width: 1536px) {
        .template-container {
            max-width: {{ $template->getMaxWidth('2_extra_large.maxwidth') == 0 ? 1536 : $template->getMaxWidth('2_extra_large.maxwidth') }}{{ $template->getMaxWidth('2_extra_large.unit') ? $template->getMaxWidth('2_extra_large.unit') : 'px' }};
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
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    {{ $template->getBackgroundStyle() }}
    {{ $template->getCustomStyle() }}
    "
    class="{{ $template->getCustomCss() }}">
    @foreach ($blocks as $block)
        {{ $block->render() }}
    @endforeach
</body>
