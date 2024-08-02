<x-filament::page>
    <div class="p-4 bg-white rounded-lg shadow-md border">
        @if (count($menus) > 0)
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <h3 class="text-xl font-semibold">Select Menu</h3>
                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model.live="selectedMenu">
                            <option value="">Select Menu</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                @if ($selectedMenu && $this->getSelectedMenu() !== null)
                    <div class="flex items-center space-x-3">
                        {{ $this->editAction }}
                        {{ $this->deleteAction }}
                    </div>
                @endif
            </div>

            @if ($selectedMenu && $this->getSelectedMenu() !== null)
                @livewire('theme::livewire.menu-item-manage', ['menu' => $this->getSelectedMenu()], key('menu-item-manage' . $selectedMenu))
            @endif
        @else
            <div class="p-4 text-center">
                No Menus Found Create a new one
            </div>
        @endif
    </div>
</x-filament::page>
