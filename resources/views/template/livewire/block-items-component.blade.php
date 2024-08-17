<div class="bg-white border border-gray-200 rounded" x-data="{ activeTab: 'blocks' }">
    <div class="border-b">
        <div class="flex items-center bg-gray-100">
            <button @click="activeTab = 'blocks'" :class="{ 'bg-white': activeTab === 'blocks' }"
                class="w-1/2 py-1">Blocks</button>
            <button @click="activeTab = 'components'" :class="{ 'bg-white': activeTab === 'components' }"
                class="w-1/2 py-1">Components</button>
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
                            @foreach ($gropedBlocks as $item)
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
                            @endforeach
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
                            @foreach ($gropedComponents as $item)
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
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
