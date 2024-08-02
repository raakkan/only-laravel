@props(['item', 'selectedItem'])

<li x-sort:item="{{ $item->id }}" wire:key="menu-item-{{ $item['id'] }}" class="mb-3">
    <div
        class="flex items-center rounded-lg border border-gray-200 shadow-sm {{ $selectedItem && $item['id'] === $selectedItem['id'] ? ' bg-gray-100' : 'bg-white hover:bg-gray-100' }}">
        <svg x-sort:handle
            class="w-6 h-6 mr-4 ml-2 cursor-move text-gray-400 hover:text-gray-600 transition duration-200 ease-in-out"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
            </path>
        </svg>
        <button wire:click="setSelectedItem({{ json_encode($item) }})"
            class="flex-1 text-left py-2 px-3 rounded-lg focus:outline-none transition duration-200 ease-in-out">
            {{ $item->name }}
        </button>
        @if ($selectedItem && $item->id === $selectedItem['id'])
            <div class="flex space-x-2 text-sm pr-3">
                {{ $this->editAction }}
                {{ $this->deleteAction }}
            </div>
        @endif
    </div>

    @if ($item->hasChildren())
        <ul x-sort="handle" class="ml-10 mt-2 space-y-3">
            @foreach ($item->children as $childIndex => $child)
                <x-themes-manager::menu.menu-item-model :item="$child" :selected-item="$selectedItem" />
            @endforeach
        </ul>
    @endif

    <x-filament-actions::modals />
</li>
