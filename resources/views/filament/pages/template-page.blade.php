<x-filament-panels::page>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css', 'resources/js/menu.ts']) }}

    <div class="mt-4 flex flex-wrap w-full">
        <div class="w-full md:w-1/4">
            <div class="bg-white mr-2 border border-gray-200 rounded" x-data="{ activeTab: 'blocks' }">
                <div x-on:show-block-settings.window="activeTab = 'settings'">
                    <div class="flex items-center bg-gray-100 p-2 space-x-2">
                        <button @click="activeTab = 'blocks'" :class="{ 'bg-white': activeTab === 'blocks' }"
                            class="w-1/2 py-2 rounded border">Blocks</button>
                        <button @click="activeTab = 'settings'" :class="{ 'bg-white': activeTab === 'settings' }"
                            class="w-1/2 py-2 rounded border">Settings</button>
                    </div>
                </div>
                <div x-show="activeTab === 'blocks'">
                    <livewire:only-laravel::template.livewire.block-items-component />
                </div>

                <div x-show="activeTab === 'settings'">
                    @if ($selectedBlock)
                        <livewire:only-laravel::template.livewire.block-settings-component :blockId="$selectedBlock"
                            :key="$selectedBlock . '-' . uniqid()" />
                    @else
                        <div class="p-2 text-gray-400 text-center">No block or component selected. click settings icon
                            to select</div>
                    @endif
                </div>
            </div>
        </div>

        <ul class="space-y-4 w-full md:w-3/4">
            @foreach ($template->blocks->whereNull('parent_id') as $block)
                <livewire:only-laravel::template.livewire.block :template="$template" :block="$block" :key="$block->id . '-' . uniqid()"
                    @show-block-settings="showBlockSettings($event.detail)" />
            @endforeach
        </ul>
    </div>
</x-filament-panels::page>
