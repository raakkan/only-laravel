<div class="bg-white border border-gray-200">
    @php
        $blockComponent = $this->getBlock();
    @endphp
    <x-only-laravel::template.component-header :label="$blockComponent->getName()" />
    <div class="p-2">
        @foreach ($blockComponent->getComponents() as $comp)
            <div class="bg-white border border-gray-200">
                <x-only-laravel::template.component-header :label="$comp->getName()" />
            </div>
        @endforeach
        <div class="mt-2 p-2 bg-gray-100 rounded border border-gray-300 flex items-center justify-center"
            x-on:drop="$wire.handleDrop(JSON.parse(event.dataTransfer.getData('text/plain'))), event.target.classList.remove('bg-blue-100')"
            x-on:dragover="event.preventDefault(); event.target.classList.add('bg-blue-100')"
            x-on:dragleave="event.target.classList.remove('bg-blue-100')">
            <x-filament::icon icon="heroicon-m-plus" class="w-5 h-5 text-gray-400 mr-3" />
            <span>Drop here</span>
        </div>
    </div>
</div>
