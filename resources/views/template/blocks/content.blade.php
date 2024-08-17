<div>
    <style>
        .content-container {
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        @media (min-width: 640px) {
            .content-container {
                max-width: 640px;
            }
        }

        @media (min-width: 768px) {
            .content-container {
                max-width: 768px;
            }
        }

        @media (min-width: 1024px) {
            .content-container {
                max-width: 1024px;
            }
        }

        @media (min-width: 1280px) {
            .content-container {
                max-width: 1280px;
            }
        }

        @media (min-width: 1536px) {
            .content-container {
                max-width: 1536px;
            }
        }
    </style>

    @php
        $settings = $block->settings;
    @endphp
    <div class="content-container">
        <div style="display: flex; width: 100%;">
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
