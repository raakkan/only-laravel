@props(['location', 'componentOnly' => false])
<div class="p-2 bg-gray-100 rounded border border-gray-300 flex items-center justify-center"
    x-on:drop="$wire.handleDrop(JSON.parse(event.dataTransfer.getData('text/plain')), '{{ $location }}', {{ $componentOnly ? 'true' : 'false' }}), $event.target.style.backgroundColor = ''"
    x-on:dragover="event.preventDefault(); $event.target.style.backgroundColor = '#93C5FD'"
    x-on:dragleave="$event.target.style.backgroundColor = ''" wire:loading.class="opacity-50" wire:target="handleDrop">
    <div wire:loading.remove wire:target="handleDrop" class="flex items-center justify-center">
        <x-filament::icon icon="heroicon-m-plus" class="w-5 h-5 text-gray-400 mr-3" />
        <span>Drop here</span>
    </div>
    <div wire:loading wire:target="handleDrop" class="flex items-center">
        <x-filament::loading-indicator class="w-5 h-5 text-gray-400 mr-3" />
        <span>Processing...</span>
    </div>
</div>
