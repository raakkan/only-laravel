<div class="rounded" x-data="{ activeTab: 'blocks' }">
    <div class="border-b">
        <div class="flex items-center bg-gray-100 font-semibold">
            <button @click="activeTab = 'blocks'" :class="{ 'bg-white': activeTab === 'blocks' }"
                class="w-1/2 py-1.5">Blocks</button>
            <button @click="activeTab = 'components'" :class="{ 'bg-white': activeTab === 'components' }"
                class="w-1/2 py-1.5">Components</button>
        </div>
    </div>

    @php
        $blocks = $this->getBlocks();
        $blockGroups = $this->getBlockGroups();
        $gropedBlocks = $this->getGrouppedBlocks();
        $components = $this->getComponents();
        $componentGroups = $this->getComponentGroups();
        $gropedComponents = $this->getGrouppedComponents();
    @endphp

    <div class="p-2 capitalize ">

        <div class="relative">
            <input type="text" name="search" id="search" wire:model.live.debounce.350ms="search"
                class="w-full px-2 py-1 @if ($search) pr-8 @endif rounded border border-gray-200 focus:outline-none mb-3"
                placeholder="Search">
            @if ($search)
                <button type="button" class="absolute right-0 top-0 mt-2 mr-2" wire:click="$set('search', '')">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @endif
        </div>

        <div x-show="activeTab === 'blocks'" class="space-y-2">
            @foreach ($blocks as $item)
                <div class="bg-gray-100 rounded border border-gray-200 cursor-move" draggable="true"
                    x-on:dragstart="event.dataTransfer.setData('text/plain', JSON.stringify(@js($item->toArray())))">
                    <div class="flex items-center justify-between py-1 px-2">
                        <span>{{ $item->getName() }}</span>
                        <x-filament::icon icon="heroicon-m-hand-raised" class="w-5 h-5 text-gray-400 rounded" />
                    </div>
                </div>
            @endforeach

            @if (count($blockGroups) > 0)
                @foreach ($blockGroups as $group)
                    <div class="border border-gray-200 rounded">
                        <div class="py-1 px-2 border-b border-gray-200">
                            <span class="font-semibold">{{ $group }}</span>
                        </div>
                        <div class="space-y-2 p-2">
                            @forelse ($gropedBlocks as $item)
                                @if ($item->getGroup() == $group)
                                    <div class="bg-gray-100 rounded border border-gray-200 cursor-move" draggable="true"
                                        x-on:dragstart="event.dataTransfer.setData('text/plain', JSON.stringify(@js($item->toArray())))">
                                        <div class="flex items-center justify-between py-1 px-2">
                                            <span>{{ $item->getName() }}</span>
                                            <x-filament::icon icon="heroicon-m-hand-raised"
                                                class="w-5 h-5 text-gray-400 rounded" />
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="p-2 text-center text-gray-400">No blocks found</div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div x-show="activeTab === 'components'" class="space-y-2">
            @foreach ($components as $item)
                <div class="bg-gray-100 rounded border border-gray-200 cursor-move" draggable="true"
                    x-on:dragstart="event.dataTransfer.setData('text/plain', JSON.stringify(@js($item->toArray())))">
                    <div class="flex items-center justify-between py-1 px-2">
                        <span>{{ $item->getName() }}</span>
                        <x-filament::icon icon="heroicon-m-hand-raised" class="w-5 h-5 text-gray-400 rounded" />
                    </div>
                </div>
            @endforeach

            @if (count($componentGroups) > 0)
                @foreach ($componentGroups as $group)
                    <div class="border border-gray-200 rounded">
                        <div class="py-1 px-2 border-b border-gray-200">
                            <span class="font-semibold">{{ $group }}</span>
                        </div>
                        <div class="space-y-2 p-2">
                            @forelse ($gropedComponents as $item)
                                @if ($item->getGroup() == $group)
                                    <div class="bg-gray-100 rounded border border-gray-200 cursor-move" draggable="true"
                                        x-on:dragstart="event.dataTransfer.setData('text/plain', JSON.stringify(@js($item->toArray())))">
                                        <div class="flex items-center justify-between py-1 px-2">
                                            <span>{{ $item->getName() }}</span>
                                            <x-filament::icon icon="heroicon-m-hand-raised"
                                                class="w-5 h-5 text-gray-400 rounded" />
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="p-2 text-center text-gray-400">No components found</div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
