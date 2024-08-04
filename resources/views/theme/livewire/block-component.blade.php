<div class="bg-white border border-gray-200">
    <div class="flex items-center justify-between p-2 border-b">
        <div class="flex items-center">
            <x-filament::icon icon="heroicon-m-bars-3" class="w-5 h-5 text-gray-400 mr-3" />
            <h2 class="text-md font-bold">Bloc</h2>
        </div>
        <div>
            <x-filament::icon-button icon="heroicon-m-trash" @click="console.log('test')" label="New label" />
        </div>
    </div>
    <div class="p-2">
        <div class="mt-2 p-2 bg-gray-100 rounded border border-gray-300 flex items-center justify-center"
            x-on:drop="$wire.handleDrop(JSON.parse(event.dataTransfer.getData('text/plain'))), event.target.classList.remove('bg-blue-100')"
            x-on:dragover="event.preventDefault(); event.target.classList.add('bg-blue-100')"
            x-on:dragleave="event.target.classList.remove('bg-blue-100')">
            <x-filament::icon icon="heroicon-m-plus" class="w-5 h-5 text-gray-400 mr-3" />
            <span>Drop here</span>
        </div>
    </div>
</div>
