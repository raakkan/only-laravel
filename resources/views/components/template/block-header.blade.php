@props(['block'])

<div class="flex items-center justify-between p-2 {{ $block->getType() === 'block' ? 'border-b' : '' }}"
    x-data="{ open: false, activeTab: 'tab1' }">
    <div class="flex items-center">
        @if ($block->isSortable())
            <x-filament::icon icon="heroicon-m-bars-3" class="w-5 h-5 text-gray-400 mr-3 cursor-move" />
        @endif
        <h2 class="text-md font-bold {{ $block->isDisabled() ? 'text-gray-400' : '' }}">{{ $block->getName() }}</h2>
    </div>
    <div class="flex items-center space-x-2">
        @if ($block->isDisableable())
            {{ $this->toggleDisableAction }}
        @endif
        @if (!$block->isDisabled())
            <x-filament::icon-button icon="heroicon-m-cog-6-tooth" x-ref="button" @click="open = ! open" color="info"
                label="Settings" />
            @if ($block->isDeletable())
                {{ $this->deleteAction }}
            @endif
        @endif
    </div>

    <div x-show="open" x-anchor="$refs.button" @click.away="open = false; activeTab = 'tab1'"
        class="w-96 mr-10 z-10 bg-white border border-gray-200 rounded-md shadow-lg">
        <div class="flex">
            <button class="p-1 flex-1 focus:outline-none bg-gray-100" :class="{ 'bg-white': activeTab === 'tab1' }"
                @click="activeTab = 'tab1'">Tab 1</button>
            @if ($block->hasColorSettings())
                <button class="p-1 flex-1 focus:outline-none bg-gray-100"
                    :class="{ 'bg-white': activeTab === 'color-settings' }" @click="activeTab = 'color-settings'">Color
                    Settings</button>
            @endif
            @if ($block->hasTextSettings())
                <button class="p-1 flex-1 focus:outline-none bg-gray-100"
                    :class="{ 'bg-white': activeTab === 'text-settings' }" @click="activeTab = 'text-settings'">Text
                    Settings</button>
            @endif
        </div>
        <div x-show="activeTab === 'tab1'" class="p-4">
            Tab 2 content
        </div>
        @if ($block->hasColorSettings())
            <div x-show="activeTab === 'color-settings'" class="p-4">
                <livewire:only-laravel::template.livewire.block-color-settings :blockModel="$block->getModel()" :key="$block->getName() . '-' . uniqid()" />
            </div>
        @endif
        @if ($block->hasTextSettings())
            <div x-show="activeTab === 'text-settings'" class="p-4">
                <livewire:only-laravel::template.livewire.block-text-settings :blockModel="$block->getModel()" :key="$block->getName() . '-' . uniqid()" />
            </div>
        @endif
    </div>

</div>
