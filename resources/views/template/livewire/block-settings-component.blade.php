<div>
    <div class="p-2 text-gray-400 text-center bg-gray-100 mb-2 rounded">
        Please click save button to save settings
    </div>
    @if (count($this->form->getComponents()) > 0)
        <form wire:submit="saveSettings">
            {{ $this->form }}
        </form>

        <div class="flex justify-end mt-5">
            <x-filament::button wire:click="save">
                Save
            </x-filament::button>
        </div>
    @else
        <div class="p-2 text-gray-400 text-center">No settings available</div>
    @endif
</div>
