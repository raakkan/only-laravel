<div class="mt-4 flex w-full bg-gray-100 border border-gray-200 rounded">
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css', 'resources/js/menu.ts']) }}

    <div class="w-2/6 p-2 border-r border-gray-200 max-h-[32rem] overflow-y-auto custom-scrollbar">
        <div class="w-full max-w-full space-y-2">
            @if (count($this->getMenuItems()) > 0)
                <div class="w-full bg-white space-y-2 p-3 rounded border border-gray-200">
                    <span class="text-gray-500 text-sm font-semibold">Default Items</span>
                    @foreach ($this->getMenuItems() as $item)
                        <x-themes-manager::menu.menu-item :item="$item" :selected-item="$selectedItem" />
                    @endforeach
                </div>
            @endif

            @foreach ($this->getMenuItemGroups() as $item)
                <x-themes-manager::menu.menu-item-group :group="$item" :selected-item="$selectedItem" />
            @endforeach

            @if (count($this->getMenuItemGroups()) == 0 && count($this->getMenuItems()) == 0)
                <div class="w-full bg-white space-y-2 p-3 rounded border border-gray-200">
                    <div class="text-gray-500 text-sm">No menu items found.</div>
                </div>
            @endif
        </div>
    </div>

    @if (count($menuItems) > 0)
        <div class="w-4/6 p-2 max-h-[32rem] overflow-y-auto custom-scrollbar" x-data="{
            handle: (item, position) => {
                $wire.updateMenuItemOrder(item, position)
            }
        }">
            <ul id="nested-sortable" x-sort="handle" class="max-w-full">
                @foreach ($menuItems as $index => $item)
                    <x-themes-manager::menu.menu-item-model :item="$item" :selected-item="$selectedItem" />
                @endforeach
            </ul>
        </div>
    @else
        <div class="w-4/6 bg-gray-100">
            <div class="p-4 max-w-full h-40 flex items-center justify-center">
                <span><b>{{ $menu->name }}</b> has no menu items</span>
            </div>
        </div>
    @endif
</div>
