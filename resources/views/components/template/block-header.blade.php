@props(['block'])

<div class="flex items-center justify-between p-2 {{ $block->getType() === 'block' ? 'border-b' : '' }}"
    x-data="{ open: false }">
    <div class="flex items-center">
        @if ($block->isSortable())
            <x-filament::icon icon="heroicon-m-bars-3" class="w-5 h-5 text-gray-400 mr-3 cursor-move" x-sort:handle />
        @endif
        <h2 class="text-md font-bold {{ $block->isDisabled() ? 'text-gray-400' : '' }}">{{ $block->getLabel() }}</h2>
    </div>
    <div class="flex items-center space-x-2">
        @if ($block->isDisableable())
            {{ $this->toggleDisableAction }}
        @endif
        @if (!$block->isDisabled())
            @if ($block->hasAnySettings())
                <x-filament::icon-button icon="heroicon-m-cog-6-tooth" x-ref="button" @click="open = ! open" color="info"
                    label="Settings" />
            @endif
            @if ($block->isDeletable())
                {{ $this->deleteAction }}
            @endif
        @endif
    </div>

    @if ($block->hasAnySettings())
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
