<x-filament::page>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css', 'resources/js/menu.ts']) }}
    <div class="mt-4 flex flex-wrap w-full">
        <div class="w-full md:w-1/4">
            <livewire:only-laravel::menu.livewire.menu-items-component />
        </div>

        <ul class="space-y-4 w-full md:w-3/4">
            <livewire:only-laravel::menu.livewire.menu-items-manage :menu="$record" />
        </ul>
    </div>
</x-filament::page>
