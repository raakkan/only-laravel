<x-filament-panels::page>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css']) }}

    <div class="mt-4 flex flex-wrap w-full">
        <div class="w-full md:w-1/4">
            <livewire:only-laravel::theme.livewire.block-items-component />
        </div>

        <div class="space-y-2 w-full md:w-3/4">
            @foreach ($template->blocks->whereNull('parent_id') as $block)
                <livewire:only-laravel::theme.livewire.block :block="$block" :key="$block->id . '-' . uniqid()" />
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
