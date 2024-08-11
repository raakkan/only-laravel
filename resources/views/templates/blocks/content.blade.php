<div>
    @php
        $settings = $block->settings;
    @endphp
    <div class="container mx-auto py-6 px-4">
        <div class="flex flex-wrap w-full">
            @if ($block->sidebar)
                @if ($block->sidebarPosition->value === 'left' || $block->sidebarPosition->value === 'both')
                    <aside style="width: 25%; background-color: #f50505">
                        @foreach ($block->getChildrensByLocation('left-sidebar') as $blockComponent)
                            {{ $blockComponent->render() }}
                        @endforeach
                    </aside>
                @endif

                <main style="width: 75%">
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
