@php
    $title = $block->getTitle();
    $subtitle = $block->getSubtitle();
    $textColor = $block->getTextColor();
    $textSize = $block->getTextSetting('font.size') ?? 1;
    $fontFamily = $block->getTextSetting('font.family');
@endphp

<section class="{{ $block->getName() }} {{ $block->getCustomCss() }}"
    style="{{ $fontFamily ? 'font-family: ' . $fontFamily . ';' : '' }} {{ $block->getBackgroundImageStyles() }} {{ $block->getCustomStyle() }}">
    <div class="flex flex-col items-center justify-center h-full text-center p-4 {{ $block->getBackgroundClasses() }}"
        style="">
        <h1 class="hero__title">{{ $title }}</h1>
        <div class="hero__description">{{ $subtitle }}</div>
    </div>

</section>

<style>
    {{ $block->getBackgroundStyles() }} {{ $block->getResponsiveHeightStyles() }} .hero__title {
        color: {{ $textColor }};
        font-size: {{ $textSize }}rem;
        margin-bottom: 1rem;
    }

    .hero__description {
        color: {{ $textColor }};
        font-size: {{ $textSize * 0.5 }}rem;
    }

    @media (max-width: 768px) {

        .hero__title {
            font-size: {{ $textSize * 0.8 }}rem;
        }

        .hero__description {
            font-size: {{ $textSize * 0.4 }}rem;
        }
    }

    @media (max-width: 480px) {
        .hero__title {
            font-size: {{ $textSize * 0.6 }}rem;
        }

        .hero__description {
            font-size: {{ $textSize * 0.3 }}rem;
        }
    }
</style>
