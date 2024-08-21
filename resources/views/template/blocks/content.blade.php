<div class="template-container" style="display: flex; width: 100%;">
    @php
        $settings = $block->settings;
    @endphp
    @if ($block->sidebar)
        @if ($block->sidebarPosition->value === 'left' || $block->sidebarPosition->value === 'both')
            <aside style="width: 25%; background-color: #f50505">
                @foreach ($block->getChildrenByLocation('left-sidebar') as $blockComponent)
                    {{ $blockComponent->render() }}
                @endforeach
            </aside>
        @endif

        <main style="{{ $block->sidebarPosition->value === 'both' ? 'width: 50%' : 'width: 75%' }}">
            @foreach ($block->getChildrenByLocation('default') as $blockComponent)
                {{ $blockComponent->render() }}
            @endforeach
        </main>

        @if ($block->sidebarPosition->value === 'right' || $block->sidebarPosition->value === 'both')
            <aside style="width: 25%; background-color: #f50505">
                @foreach ($block->getChildrenByLocation('right-sidebar') as $blockComponent)
                    {{ $blockComponent->render() }}
                @endforeach
            </aside>
        @endif
    @else
        <main style="width: 100%">
            @yield('content')
        </main>
    @endif
</div>
