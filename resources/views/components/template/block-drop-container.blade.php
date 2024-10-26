@props(['location', 'componentOnly' => false])
<div class="p-2 bg-gray-100 rounded border border-gray-300 flex items-center justify-center"
    x-on:drop="$wire.handleDrop(JSON.parse(event.dataTransfer.getData('text/plain')), '{{ $location }}', {{ $componentOnly ? 'true' : 'false' }}), $event.target.style.backgroundColor = ''"
    x-on:dragover="event.preventDefault(); $event.target.style.backgroundColor = '#93C5FD'"
    x-on:dragleave="$event.target.style.backgroundColor = ''" wire:loading.class="opacity-50" wire:target="handleDrop">
    <div wire:loading.remove wire:target="handleDrop" class="flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-5 h-5 text-gray-400 mr-3">
            <path fill-rule="evenodd"
                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                clip-rule="evenodd" />
        </svg>
        <span>Drop here</span>
    </div>
    <div wire:loading wire:target="handleDrop" class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 mr-3 animate-spin" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        <span>Processing...</span>
    </div>
</div>
