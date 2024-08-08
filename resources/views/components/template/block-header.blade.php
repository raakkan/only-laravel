@props(['block'])

<div class="flex items-center justify-between p-2 {{ $block->getType() === 'block' ? 'border-b' : '' }}">
    <div class="flex items-center">
        @if ($block->isSortable())
            <x-filament::icon icon="heroicon-m-bars-3" class="w-5 h-5 text-gray-400 mr-3 cursor-move" />
        @endif
        <h2 class="text-md font-bold">{{ $block->getName() }}</h2>
    </div>
    <div class="flex items-center space-x-2">
        <x-filament::icon-button icon="heroicon-m-cog-6-tooth"
            @click="$dispatch('show-block-settings', {{ $block->getModel()->id }})" color="info" label="Settings" />
        @if ($block->isDeletable())
            {{ $this->deleteAction }}
        @endif
    </div>
</div>
