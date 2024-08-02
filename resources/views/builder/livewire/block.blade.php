<div class="bg-white border border-gray-200">
    <x-themes-manager::builder.header title="{{ $block['label'] }}" />
    <div class="p-2">
        <div class="space-y-2">
            @foreach ($blocks as $item)
                @if ($item['type'] === 'block')
                    <livewire:theme::builder.livewire.block :block="$item" :key="$item['id']" />
                @else
                    <div class="p-2 bg-gray-100 rounded border border-gray-300">{{ $item['id'] }}</div>
                @endif
            @endforeach
        </div>
        <div class="mt-2 p-2 bg-gray-100 rounded border border-gray-300 flex items-center justify-center"
            x-on:drop="$wire.handleDrop(JSON.parse(event.dataTransfer.getData('text/plain'))), event.target.classList.remove('bg-blue-100')"
            x-on:dragover="event.preventDefault(); event.target.classList.add('bg-blue-100')"
            x-on:dragleave="event.target.classList.remove('bg-blue-100')">
            <x-filament::icon icon="heroicon-m-plus" class="w-5 h-5 text-gray-400 mr-3" />
            <span>Drop here</span>
        </div>
    </div>
</div>
