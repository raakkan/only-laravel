<x-filament-panels::page>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css']) }}

    @php
        $template = $this->getTemplate();
    @endphp
    <div class="mt-4 flex flex-wrap w-full">
        <div class="w-full md:w-1/4">
            <livewire:only-laravel::theme.livewire.block-items-component />
        </div>

        <div class="space-y-2 w-full md:w-3/4">
            @foreach ($template->getBlocks() as $block)
                <livewire:only-laravel::theme.livewire.block-component :block="$block->toArray()" :key="$block->getName()" />
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
