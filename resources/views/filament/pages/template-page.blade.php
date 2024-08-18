<x-filament-panels::page>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css', 'resources/js/menu.ts']) }}

    <div class="mt-4 flex flex-wrap w-full">
        <div class="w-full md:w-1/4">
            <div class="bg-white mr-2 border border-gray-200 rounded" x-data="{ activeTab: 'blocks' }">
                <div x-on:show-block-settings.window="activeTab = 'settings'" class="border-b border-gray-200">
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

                <div x-show="activeTab === 'settings'" class="p-2 bg-gray-100">
                    <livewire:only-laravel::template.livewire.template-settings :template="$record" :key="$record->id . '-' . uniqid()" />
                </div>
            </div>
        </div>

        <ul class="space-y-4 w-full md:w-3/4">
            @foreach ($record->blocks->whereNull('parent_id') as $block)
                <livewire:only-laravel::template.livewire.block :template="$record" :block="$block" :key="$block->id . '-' . uniqid()"
                    @show-block-settings="showBlockSettings($event.detail)" />
            @endforeach
        </ul>
    </div>
</x-filament-panels::page>
