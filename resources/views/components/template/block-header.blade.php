@props(['block'])

@php
    $defaultTab = null;

    if ($block->hasSettings()) {
        $defaultTab = 'settings';
    } elseif ($block->hasColorSettings()) {
        $defaultTab = 'color-settings';
    } elseif ($block->hasTextSettings()) {
        $defaultTab = 'text-settings';
    }
@endphp

<div class="flex items-center justify-between p-2 {{ $block->getType() === 'block' ? 'border-b' : '' }}"
    x-data="{ open: false, activeTab: '{{ $defaultTab }}' }">
    <div class="flex items-center">
        @if ($block->isSortable())
            <x-filament::icon icon="heroicon-m-bars-3" class="w-5 h-5 text-gray-400 mr-3 cursor-move" x-sort:handle />
        @endif
        <h2 class="text-md font-bold {{ $block->isDisabled() ? 'text-gray-400' : '' }}">{{ $block->getName() }}</h2>
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
        <div x-show="open" x-anchor.bottom-end="$refs.button"
            @click.away="open = false; activeTab = '{{ $defaultTab }}'"
            class="w-96 mr-10 z-10 bg-white border border-gray-200 rounded-lg shadow-2xl">
            <div class="flex border-b border-gray-200 font-semibold rounded-t-lg">
                @if ($block->hasSettings())
                    <button class="px-1 py-2 flex-1 focus:outline-none bg-gray-100 rounded-t-lg"
                        :class="{ 'bg-white': activeTab === 'settings' }"
                        @click="activeTab = 'settings'">Settings</button>
                @endif
                @if ($block->hasColorSettings())
                    <button class="px-1 py-2 flex-1 focus:outline-none bg-gray-100 rounded-t-lg"
                        :class="{ 'bg-white': activeTab === 'color-settings' }"
                        @click="activeTab = 'color-settings'">Color
                        Settings</button>
                @endif
                @if ($block->hasTextSettings())
                    <button class="px-1 py-2 flex-1 focus:outline-none bg-gray-100 rounded-t-lg"
                        :class="{ 'bg-white': activeTab === 'text-settings' }" @click="activeTab = 'text-settings'">Text
                        Settings</button>
                @endif
            </div>

            @if ($block->hasSettings())
                <div x-show="activeTab === 'settings'" class="p-4">
                    <livewire:only-laravel::template.livewire.block-settings-component :blockModel="$block->getModel()"
                        :key="$block->getName() . '-' . uniqid()" />
                </div>
            @endif
            @if ($block->hasColorSettings())
                <div x-show="activeTab === 'color-settings'" class="p-4">
                    <livewire:only-laravel::template.livewire.block-color-settings :blockModel="$block->getModel()"
                        :key="$block->getName() . '-' . uniqid()" />
                </div>
            @endif
            @if ($block->hasTextSettings())
                <div x-show="activeTab === 'text-settings'" class="p-4">
                    <livewire:only-laravel::template.livewire.block-text-settings :blockModel="$block->getModel()" :key="$block->getName() . '-' . uniqid()" />
                </div>
            @endif
        </div>
    @endif

</div>
