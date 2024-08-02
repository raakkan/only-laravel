@props(['group', 'selectedItem'])


<div x-data="{ open: false }" class="w-full bg-white rounded border border-gray-200">
    <button @click="open = !open" class="flex items-center justify-between w-full bg-white px-3 py-2 rounded">
        <span>{{ $group->getName() }}</span>
        <svg x-bind:class="{ 'rotate-180': open }" class="w-5 h-5 ml-2 transition-transform duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-show="open" x-collapse class="space-y-2 px-3 pb-3">
        @foreach ($group->getItems() as $item)
            <x-themes-manager::menu.menu-item :item="$item" :selected-item="$selectedItem" />
        @endforeach
    </div>
</div>
