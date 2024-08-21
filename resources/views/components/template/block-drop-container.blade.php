@props(['location', 'componentOnly' => false])
<div class="p-2 bg-gray-100 rounded border border-gray-300 flex items-center justify-center"
    x-on:drop="$wire.handleDrop(JSON.parse(event.dataTransfer.getData('text/plain')), '{{ $location }}', {{ $componentOnly ? 'true' : 'false' }}), event.target.classList.remove('bg-blue-100')"
    x-on:dragover="event.preventDefault(); event.target.classList.add('bg-blue-100')"
    x-on:dragleave="event.target.classList.remove('bg-blue-100')">
    <x-filament::icon icon="heroicon-m-plus" class="w-5 h-5 text-gray-400 mr-3" />
    <span>Drop here</span>
</div>
