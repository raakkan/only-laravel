<div class="relative group" draggable="true">
    <div
        class="block w-full text-left bg-gray-100 p-2 rounded-lg group-hover:bg-gray-200 transition border border-gray-200">
        {{ $item->getLabel() }}
    </div>
    <div class="absolute right-2 top-1/2 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 transition">
        <button wire:click="addMenuItem({{ json_encode($item->toArray()) }})"
            class="bg-blue-500 text-white text-xs p-2 rounded mr-1">
            Add
        </button>
        @if ($selectedItem && isset($selectedItem['id']))
            <button wire:click="addAsChild({{ json_encode($item->toArray()) }})"
                class="bg-green-500 text-white text-xs p-2 rounded">
                Add as child
            </button>
        @endif
    </div>
</div>
