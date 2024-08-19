<li x-sort:item="{{ $item->id }}">
    <div class="flex items-center space-x-2 border border-gray-200 p-2">
        <x-filament::icon icon="heroicon-m-bars-3" class="w-5 h-5 text-gray-400 mr-3 cursor-move" x-sort:handle />
        {{ $item->name }}
    </div>

    <ul class="space-y-2 pl-2 mt-2" x-sort="handle">
        @foreach ($item->children as $child)
            <livewire:only-laravel::menu.livewire.menu-item-component :item="$child" :menu="$menu"
                :key="$child->id . '-' . uniqid()" />
        @endforeach
    </ul>
</li>
