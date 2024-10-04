<div class="template-container" style="display: flex; width: 100%;">
    @php
        $settings = $block->settings;
    @endphp
    @if ($block->sidebar)
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 w-full mt-4">
            @if ($block->sidebarPosition->value === 'left' || $block->sidebarPosition->value === 'both')
                <aside class="w-full md:w-1/4 space-y-2 mr-0 md:mr-2">
                    @foreach ($block->getChildrenByLocation('left-sidebar') as $blockComponent)
                        {!! $blockComponent->render() !!}
                    @endforeach
                </aside>
            @endif

            <main
                class="{{ $block->sidebarPosition->value === 'both' ? 'w-full md:w-1/2 mx-0 md:mx-2 space-y-2' : 'w-full md:w-3/4 space-y-2' }}">
                @foreach ($block->getChildrenByLocation('default') as $blockComponent)
                    {!! $blockComponent->render() !!}
                @endforeach
            </main>

            @if ($block->sidebarPosition->value === 'right' || $block->sidebarPosition->value === 'both')
                <aside class="w-full md:w-1/4 space-y-2 ml-0 md:ml-2">
                    @foreach ($block->getChildrenByLocation('right-sidebar') as $blockComponent)
                        {!! $blockComponent->render() !!}
                    @endforeach
                </aside>
            @endif
        </div>
    @else
        <main class="w-full space-y-2 mt-4">
            @foreach ($block->getChildrenByLocation('default') as $blockComponent)
                {!! $blockComponent->render() !!}
            @endforeach
        </main>
    @endif
</div>
