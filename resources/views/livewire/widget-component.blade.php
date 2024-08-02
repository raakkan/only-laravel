<div x-data="{ open: false }" class="mb-4 bg-gray-100 border border-gray-200 rounded-lg">
    <div class="flex items-center justify-between cursor-pointer px-4 py-3 bg-gray-200 rounded-t-lg"
        @click="open = !open">
        <span class="text-lg font-semibold">{{ $widget->name }}</span>
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

    <div x-show="open" class="flex flex-col">
        @if (count($this->form->getComponents()) > 0)
            <form wire:submit="saveSettings">
                <div class="p-4">
                    {{ $this->form }}
                </div>
                <div class="flex justify-end px-4 py-3 space-x-2 bg-gray-200">
                    <x-themes-manager::button size="sm" type="submit">Save</x-themes-manager::button>
                    <x-themes-manager::button size="sm" type="button" wire:click="removeWidget"
                        wireTarget="removeWidget" color="bg-red-500 text-white">Remove</x-themes-manager::button>
                </div>
            </form>
        @else
            <div class="flex justify-end px-4 py-3 space-x-2 bg-gray-200">
                <x-themes-manager::button size="sm" type="button" wire:click="removeWidget"
                    wireTarget="removeWidget" color="bg-red-500 text-white">Remove</x-themes-manager::button>
            </div>
        @endif
    </div>
    <x-filament-actions::modals />
</div>
