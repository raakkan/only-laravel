@php
    $blocks = $template->getBlocks();

    $mobileSpacing = $template->getTemplateSetting('spacing.mobile') ?? 0;
    $tabletSpacing = $template->getTemplateSetting('spacing.tablet') ?? 0;
    $tabletWideSpacing = $template->getTemplateSetting('spacing.tablet_wide') ?? 0;
    $laptopSpacing = $template->getTemplateSetting('spacing.laptop') ?? 2;
    $desktopSpacing = $template->getTemplateSetting('spacing.desktop') ?? 0;
    $desktopWideSpacing = $template->getTemplateSetting('spacing.desktop_wide') ?? 0;
@endphp

<style>
    .template-container {
        @if ($template->mobileMaxWidthUnit === 'percentage')
            max-width: {{ $template->mobileMaxWidth == 0 ? 640 : $template->mobileMaxWidth }}%;
        @else
            max-width: {{ $template->mobileMaxWidth == 0 ? 640 : $template->mobileMaxWidth }}px;
        @endif
        margin-left: auto;
        margin-right: auto;
        padding-left: {{ $mobileSpacing }}rem;
        padding-right: {{ $mobileSpacing }}rem;
    }

    @media (min-width: 640px) {
        .template-container {
            @if ($template->tabletMaxWidthUnit === 'percentage')
                max-width: {{ $template->tabletMaxWidth == 0 ? 640 : $template->tabletMaxWidth }}%;
            @else
                max-width: {{ $template->tabletMaxWidth == 0 ? 640 : $template->tabletMaxWidth }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $tabletSpacing }}rem;
            padding-right: {{ $tabletSpacing }}rem;
        }
    }

    @media (min-width: 768px) {
        .template-container {
            @if ($template->tabletWideMaxWidthUnit === 'percentage')
                max-width: {{ $template->tabletWideMaxWidth == 0 ? 768 : $template->tabletWideMaxWidth }}%;
            @else
                max-width: {{ $template->tabletWideMaxWidth == 0 ? 768 : $template->tabletWideMaxWidth }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $tabletWideSpacing }}rem;
            padding-right: {{ $tabletWideSpacing }}rem;
        }
    }

    @media (min-width: 1024px) {
        .template-container {
            @if ($template->laptopMaxWidthUnit === 'percentage')
                max-width: {{ $template->laptopMaxWidth == 0 ? 1024 : $template->laptopMaxWidth }}%;
            @else
                max-width: {{ $template->laptopMaxWidth == 0 ? 1024 : $template->laptopMaxWidth }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $laptopSpacing }}rem;
            padding-right: {{ $laptopSpacing }}rem;
        }
    }

    @media (min-width: 1280px) {
        .template-container {
            @if ($template->desktopMaxWidthUnit === 'percentage')
                max-width: {{ $template->desktopMaxWidth == 0 ? 1280 : $template->desktopMaxWidth }}%;
            @else
                max-width: {{ $template->desktopMaxWidth == 0 ? 1280 : $template->desktopMaxWidth }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $desktopSpacing }}rem;
            padding-right: {{ $desktopSpacing }}rem;
        }
    }

    @media (min-width: 1536px) {
        .template-container {
            @if ($template->desktopWideMaxWidthUnit === 'percentage')
                max-width: {{ $template->desktopWideMaxWidth == 0 ? 1536 : $template->desktopWideMaxWidth }}%;
            @else
                max-width: {{ $template->desktopWideMaxWidth == 0 ? 1536 : $template->desktopWideMaxWidth }}px;
            @endif
            margin-left: auto;
            margin-right: auto;
            padding-left: {{ $desktopWideSpacing }}rem;
            padding-right: {{ $desktopWideSpacing }}rem;
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
