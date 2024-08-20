@php
    $defaultTab = 'settings';
@endphp
<li x-sort:item="{{ $item->id }}" class="border-l border-gray-200" x-data="{ open: false, activeTab: '{{ $defaultTab }}' }">
    <div class="flex items-center justify-between border-y border-r border-gray-200 p-2"
        x-on:dragover="event.preventDefault(); event.target.classList.add('bg-blue-100')"
        x-on:dragleave="event.target.classList.remove('bg-blue-100')"
        x-on:drop="$wire.handleDrop(JSON.parse(event.dataTransfer.getData('text/plain'))), event.target.classList.remove('bg-blue-100')">
        <div class="flex items-center space-x-2">
            <x-filament::icon icon="heroicon-m-bars-3" class="w-5 h-5 text-gray-400 mr-3 cursor-move" x-sort:handle />
            {{ $item->label ?? $item->name }}
        </div>
        <div class="flex items-center space-x-2">
            <x-filament::icon-button icon="heroicon-m-cog-6-tooth" x-ref="button" @click="open = ! open" color="info"
                label="Settings" />
            {{ $this->deleteAction }}
        </div>
    </div>

    <div x-show="open" x-anchor.bottom-end="$refs.button" @click.away="open = false; activeTab = '{{ $defaultTab }}'"
        class="w-96 mr-10 z-10 bg-white border border-gray-200 rounded-lg shadow-2xl">
        <div class="flex border-b border-gray-200 font-semibold rounded-t-lg">
            <button class="px-1 py-2 flex-1 focus:outline-none bg-gray-100 rounded-t-lg"
                :class="{ 'bg-white': activeTab === 'settings' }" @click="activeTab = 'settings'">Settings</button>
        </div>

        <div x-show="activeTab === 'settings'" class="p-4">
            {{ $this->form }}
            <div class="flex justify-end mt-5">
                <x-filament::button wire:click="save">
                    Save
                </x-filament::button>
            </div>
        </div>
    </div>

    @if ($item->children->isNotEmpty())
        <ul class="space-y-2 pl-2 mt-2" x-sort="handle">
            @foreach ($item->children as $child)
                <livewire:only-laravel::menu.livewire.menu-item-component :item="$child" :menu="$menu"
                    :key="$child->id . '-' . uniqid()" />
            @endforeach
        </ul>
    @endif
    <x-filament-actions::modals />
</li>
