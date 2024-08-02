<div x-data="{ open: true }" class="mb-4 bg-gray-50 border border-gray-200 rounded-lg">
    <div class="flex items-center justify-between cursor-pointer px-4 py-3 bg-gray-100 rounded-t-lg"
        @click="open = !open">
        <span class="text-lg font-semibold">{{ $location->label }}</span>
        <svg x-show="open" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
        <svg x-show="!open" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
    </div>

    <div x-show="open" class="p-4 flex">
        <div class="w-1/3 pr-4">
            <h3 class="text-lg font-semibold mb-2">Add Widget</h3>
            <select wire:model.live="selectedWidget" class="w-full border border-gray-300 rounded-md px-2 py-1">
                <option value="">Select a widget</option>
                @foreach ($this->getThemeWidgets() as $widget)
                    <option value="{{ $widget->getId() }}">{{ $widget->getName() }}</option>
                @endforeach
            </select>
            <x-themes-manager::button wire:click="addWidget" :loading="true" wireTarget="addWidget" :disabled="!$selectedWidget"
                class="mt-2">Add</x-themes-manager::button>

        </div>
        <div class="w-2/3">
            @forelse ($location->widgets as $widget)
                @livewire('theme::livewire.widget-component', ['location' => $location, 'widget' => $widget], key('widget-' . $location->name . '-' . $widget->id))
            @empty
                <p>No widgets in this location</p>
            @endforelse
        </div>
    </div>
</div>
