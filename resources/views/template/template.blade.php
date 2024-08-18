@php
    $blocks = $template->getBlocks();
    $mobileMaxWidth = $template->getTemplateSetting('maxwidth.mobile') ?? 100;
    $tabletMaxWidth = $template->getTemplateSetting('maxwidth.tablet') ?? 640;
    $tabletWideMaxWidth = $template->getTemplateSetting('minwidth.tablet_wide') ?? 768;
    $laptopMaxWidth = $template->getTemplateSetting('maxwidth.laptop') ?? 1024;
    $desktopMaxWidth = $template->getTemplateSetting('maxwidth.desktop') ?? 1280;
    $desktopWideMaxWidth = $template->getTemplateSetting('minwidth.desktop_wide') ?? 1536;

    $mobileSpacing = $template->getTemplateSetting('spacing.mobile') ?? 0.5;
    $tabletSpacing = $template->getTemplateSetting('spacing.tablet') ?? 1;
    $tabletWideSpacing = $template->getTemplateSetting('spacing.tablet_wide') ?? 1.5;
    $laptopSpacing = $template->getTemplateSetting('spacing.laptop') ?? 2;
    $desktopSpacing = $template->getTemplateSetting('spacing.desktop') ?? 2;
    $desktopWideSpacing = $template->getTemplateSetting('spacing.desktop_wide') ?? 3;
@endphp

<style>
    .template-container {
        max-width: {{ $mobileMaxWidth }}%;
        margin-left: auto;
        margin-right: auto;
        padding-left: {{ $mobileSpacing }}rem;
        padding-right: {{ $mobileSpacing }}rem;
    }

    @media (min-width: 640px) {
        .template-container {
            max-width: {{ $tabletMaxWidth }}px;
            padding-left: {{ $tabletSpacing }}rem;
            padding-right: {{ $tabletSpacing }}rem;
        }
    }

    @media (min-width: 768px) {
        .template-container {
            max-width: {{ $tabletWideMaxWidth }}px;
            padding-left: {{ $tabletWideSpacing }}rem;
            padding-right: {{ $tabletWideSpacing }}rem;
        }
    }

    @media (min-width: 1024px) {
        .template-container {
            max-width: {{ $laptopMaxWidth }}px;
            padding-left: {{ $laptopSpacing }}rem;
            padding-right: {{ $laptopSpacing }}rem;
        }
    }

    @media (min-width: 1280px) {
        .template-container {
            max-width: {{ $desktopMaxWidth }}px;
            padding-left: {{ $desktopSpacing }}rem;
            padding-right: {{ $desktopSpacing }}rem;
        }
    }

    @media (min-width: 1536px) {
        .template-container {
            max-width: {{ $desktopWideMaxWidth }}px;
            padding-left: {{ $desktopWideSpacing }}rem;
            padding-right: {{ $desktopWideSpacing }}rem;
        }
    }
</style>

@foreach ($blocks as $block)
    {{ $block->render() }}
@endforeach
