@php
    $title = $block->getTitle();
    $description = $block->getDescription();
    $textColor = $block->getTextColor();
    $textSize = $block->getTextSetting('font.size');
@endphp

<section class="{{ $block->getName() }} {{ $block->getBackgroundClasses() }}">
    <div class="hero__content" style="{{ $block->getBackgroundStyles() }}">
        <h1 class="hero__title">{{ $title }}</h1>
        <div class="hero__description">{{ $description }}</div>
    </div>

</section>

<style>
    {{ $block->getBackgroundStyles() }} {{ $block->getResponsiveHeightStyles() }} .hero__content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align: center;
        padding: 1rem;
    }

    .hero__title {
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
