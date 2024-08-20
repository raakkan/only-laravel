<div class="bg-white rounded-lg border border-gray-200">
    <div class="px-4 py-2 rounded-t-lg border-b border-gray-100 font-semibold">
        Manage Menu Items
    </div>

    <div class="p-2">
        <ul class="space-y-2" x-data="{
            handle: (item, position) => {
                $wire.updateOrder(item, position)
            }
        }" x-sort="handle">
            @forelse ($menu->items->where('parent_id', null) as $item)
                <livewire:only-laravel::menu.livewire.menu-item-component :item="$item" :menu="$menu"
                    :key="$item->id . '-' . uniqid()" />
            @empty
                <div class="text-gray-400 text-center p-2">
                    No menu items found
                </div>
            @endforelse
        </ul>
        <div class="mt-2 p-2 bg-gray-100 rounded border border-gray-300 flex items-center justify-center"
            x-on:drop="$wire.handleDrop(JSON.parse(event.dataTransfer.getData('text/plain'))), event.target.classList.remove('bg-blue-100')"
            x-on:dragover="event.preventDefault(); event.target.classList.add('bg-blue-100')"
            x-on:dragleave="event.target.classList.remove('bg-blue-100')">
            <x-filament::icon icon="heroicon-m-plus" class="w-5 h-5 text-gray-400 mr-3" />
            <span>Drop here</span>
        </div>
    </div>
</div>
