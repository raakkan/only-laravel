<nav style="
    {{ $block->backgroundColor ? 'background-color: ' . $block->backgroundColor . ';' : '' }}
    {{ $block->textColor ? 'color: ' . $block->textColor . ';' : '' }}
    {{ $block->fontFamily ? 'font-family: ' . $block->fontFamily . ';' : '' }}
    {{ $block->fontSize ? 'font-size: ' . $block->fontSize . 'rem;' : '' }}
     
        display: flex;
        justify-content: {{ $block->justifyContent }};
        align-items: center;
"
    class="template-container">
    @php
        $navigationStartComponent = collect($block->getChildrenByLocation('navigation-start'))->first();
        $navigationCenterComponent = collect($block->getChildrenByLocation('navigation-center'))->first();
        $navigationEndComponent = collect($block->getChildrenByLocation('navigation-end'))->first();
    @endphp

    @if ($block->showStartComponent() && $navigationStartComponent)
        {{ $navigationStartComponent->render() }}
    @endif

    @if ($block->showCenterComponent() && $navigationCenterComponent)
        {{ $navigationCenterComponent->render() }}
    @endif

    @if ($block->showEndComponent() && $navigationEndComponent)
        {{ $navigationEndComponent->render() }}
    @endif
</nav>
