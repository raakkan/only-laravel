<div class="rounded" x-data="{ activeTab: 'components' }">
    <div class="border-b">
        <div class="flex items-center bg-gray-100 font-semibold">
            <button @click="activeTab = 'components'" :class="{ 'bg-white': activeTab === 'components' }"
                class="w-1/2 py-2">Components</button>
            <button @click="activeTab = 'blocks'" :class="{ 'bg-white': activeTab === 'blocks' }"
                class="w-1/2 py-2">Blocks</button>
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

    <div class="p-2 capitalize space-y-2">

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
                        <span>{{ $item->getLabel() }}</span>
                        <svg class="w-5 h-5 text-gray-400 rounded" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11 2a1 1 0 10-2 0v6.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V5a1 1 0 10-2 0v7a7 7 0 1014 0V8a1 1 0 10-2 0v3.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V2z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            @endforeach

            @if (count($blockGroups) > 0)
                @foreach ($blockGroups as $group)
                    <div class="border border-gray-200 rounded" x-data="{ open: false }">
                        <div class="py-1 px-2 border-b border-gray-200 cursor-pointer flex items-center justify-between"
                            x-on:click="open = !open">
                            <span class="font-semibold">{{ $group }}</span>
                            <svg x-show="!open" class="w-5 h-5 text-gray-400 rounded" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg x-show="open" class="w-5 h-5 text-gray-400 rounded" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="space-y-2 p-2" x-show="open" x-collapse>
                            @forelse ($gropedBlocks as $item)
                                @if ($item->getGroup() == $group)
                                    <div class="bg-gray-100 rounded border border-gray-200 cursor-move" draggable="true"
                                        x-on:dragstart="event.dataTransfer.setData('text/plain', JSON.stringify(@js($item->toArray())))">
                                        <div class="flex items-center justify-between py-1 px-2">
                                            <span>{{ $item->getLabel() }}</span>
                                            <svg class="w-5 h-5 text-gray-400 rounded"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M11 2a1 1 0 10-2 0v6.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V5a1 1 0 10-2 0v7a7 7 0 1014 0V8a1 1 0 10-2 0v3.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V2z"
                                                    clip-rule="evenodd" />
                                            </svg>
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
                        <span>{{ $item->getLabel() }}</span>
                        <svg class="w-5 h-5 text-gray-400 rounded" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11 2a1 1 0 10-2 0v6.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V5a1 1 0 10-2 0v7a7 7 0 1014 0V8a1 1 0 10-2 0v3.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V2z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            @endforeach

            @if (count($componentGroups) > 0)
                @foreach ($componentGroups as $group)
                    <div class="border border-gray-200 rounded" x-data="{ open: false }">
                        <div class="py-1 px-2 border-b border-gray-200 cursor-pointer flex items-center justify-between"
                            x-on:click="open = !open">
                            <span class="font-semibold">{{ $group }}</span>
                            <svg x-show="!open" class="w-5 h-5 text-gray-400 rounded" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg x-show="open" class="w-5 h-5 text-gray-400 rounded" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="space-y-2 p-2" x-show="open" x-collapse>
                            @forelse ($gropedComponents as $item)
                                @if ($item->getGroup() == $group)
                                    <div class="bg-gray-100 rounded border border-gray-200 cursor-move"
                                        draggable="true"
                                        x-on:dragstart="event.dataTransfer.setData('text/plain', JSON.stringify(@js($item->toArray())))">
                                        <div class="flex items-center justify-between py-1 px-2">
                                            <span>{{ $item->getLabel() }}</span>
                                            <svg class="w-5 h-5 text-gray-400 rounded"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M11 2a1 1 0 10-2 0v6.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V5a1 1 0 10-2 0v7a7 7 0 1014 0V8a1 1 0 10-2 0v3.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V2z"
                                                    clip-rule="evenodd" />
                                            </svg>
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
