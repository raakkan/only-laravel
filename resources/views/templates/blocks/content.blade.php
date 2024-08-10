<div>
    @php
        $settings = $block->settings;
    @endphp
    <div class="container mx-auto py-6 px-4">
        <div class="flex flex-wrap w-full">
            @if ($block->sidebar)
                @if ($block->sidebarPosition === 'left')
                    <aside style="width: 25%; background-color: #f5f5f5">
                        sidebar
                    </aside>
                @endif

                <main style="width: 75%">
                    @yield('content')
                </main>

                @if ($block->sidebarPosition === 'right')
                    <aside style="width: 25%; background-color: #f5f5f5">
                        sidebar
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
