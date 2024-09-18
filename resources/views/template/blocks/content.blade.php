<div class="template-container" style="display: flex; width: 100%;">
    @php
        $settings = $block->settings;
    @endphp
    @if ($block->sidebar)
        <div class="content-container">
            @if ($block->sidebarPosition->value === 'left' || $block->sidebarPosition->value === 'both')
                <aside class="left-sidebar">
                    @foreach ($block->getChildrenByLocation('left-sidebar') as $blockComponent)
                        {!! $blockComponent->render() !!}
                    @endforeach
                </aside>
            @endif

            <main class="{{ $block->sidebarPosition->value === 'both' ? 'main-content-both' : 'main-content-sidebar' }}">
                @foreach ($block->getChildrenByLocation('default') as $blockComponent)
                    {!! $blockComponent->render() !!}
                @endforeach
            </main>

            @if ($block->sidebarPosition->value === 'right' || $block->sidebarPosition->value === 'both')
                <aside class="right-sidebar">
                    @foreach ($block->getChildrenByLocation('right-sidebar') as $blockComponent)
                        {!! $blockComponent->render() !!}
                    @endforeach
                </aside>
            @endif
        </div>
    @else
        <main class="main-content-no-sidebar">
            @foreach ($block->getChildrenByLocation('default') as $blockComponent)
                {!! $blockComponent->render() !!}
            @endforeach
        </main>
    @endif
</div>
