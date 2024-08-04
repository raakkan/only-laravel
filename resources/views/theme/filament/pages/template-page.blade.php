<x-filament-panels::page>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css']) }}

    @php
        $template = $this->getTemplate();
    @endphp
    <div class="mt-4 flex flex-wrap w-full">
        <div class="w-full md:w-1/4">
            <div class="bg-white shadow p-4 mr-2 cursor-move h" draggable="true"
                x-on:dragstart="event.dataTransfer.setData('text/plain', JSON.stringify({
name: 'div',
label: 'Div',
type: 'block'
}))">
                block
            </div>

        </div>

        <div class="space-y-2 w-full md:w-3/4">
            {{ $template->getName() }}

            @foreach ($template->getBlocks() as $block)
                <livewire:only-laravel::theme.livewire.block-component :block="$block" :key="$block->getName()" />
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
