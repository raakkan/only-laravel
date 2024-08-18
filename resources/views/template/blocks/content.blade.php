<div>
    @php
        $settings = $block->settings;
    @endphp
    <div class="template-container">
        <div style="display: flex; width: 100%;">
            @if ($block->sidebar)
                @if ($block->sidebarPosition->value === 'left' || $block->sidebarPosition->value === 'both')
                    <aside style="width: 25%; background-color: #f50505">
                        @foreach ($block->getChildrensByLocation('left-sidebar') as $blockComponent)
                            {{ $blockComponent->render() }}
                        @endforeach
                    </aside>
                @endif

                <main style="{{ $block->sidebarPosition->value === 'both' ? 'width: 50%' : 'width: 75%' }}">
                    @foreach ($block->getChildrensByLocation('default') as $blockComponent)
                        {{ $blockComponent->render() }}
                    @endforeach
                </main>

                @if ($block->sidebarPosition->value === 'right' || $block->sidebarPosition->value === 'both')
                    <aside style="width: 25%; background-color: #f50505">
                        @foreach ($block->getChildrensByLocation('right-sidebar') as $blockComponent)
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
    </div>
</div>
