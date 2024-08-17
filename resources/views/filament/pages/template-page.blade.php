<x-filament-panels::page>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css', 'resources/js/menu.ts']) }}

    <div class="mt-4 flex flex-wrap w-full">
        <div class="w-full md:w-1/4">
            <livewire:only-laravel::template.livewire.block-items-component />
        </div>

        <ul class="space-y-4 w-full md:w-3/4">
            @foreach ($record->blocks->whereNull('parent_id') as $block)
                <livewire:only-laravel::template.livewire.block :template="$record" :block="$block" :key="$block->id . '-' . uniqid()"
                    @show-block-settings="showBlockSettings($event.detail)" />
            @endforeach
        </ul>
    </div>
</x-filament-panels::page>
