@props(['block'])

<div class="flex items-center justify-between p-2 {{ $block->getType() === 'block' ? 'border-b' : '' }}"
    x-data="{ open: false }">
    <div class="flex items-center">
        @if ($block->isSortable())
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 text-gray-400 mr-3 cursor-move" x-sort:handle>
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        @endif
        <h2 class="text-md font-bold {{ $block->isDisabled() ? 'text-gray-400' : '' }}">{{ $block->getLabel() }}</h2>
    </div>
    <div class="flex items-center space-x-2">
        @if (!$block->isDisabled())
            @if ($block->hasAnySettings())
                <button x-ref="button" @click="open = ! open" class="text-info-500 hover:text-info-600 p-2"
                    title="Settings">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            @endif
        @endif
    </div>

    @if (!$block->isDisabled() && $block->hasAnySettings())
        <div x-show="open" x-anchor.bottom-end="$refs.button" @click.away="open = false;"
            class="w-1/3 mr-10 z-10 bg-white border border-gray-200 rounded-lg shadow-2xl">
            @php
                $tabsData = $block->getSettingsTabsData();
                $firstName = $tabsData[0]['name'];
            @endphp
            <x-only-laravel::template.block-setting-tabs :data="$tabsData" :activeTab="$firstName" :block="$block" />
        </div>
    @endif

</div>
