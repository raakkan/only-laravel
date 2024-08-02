{{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css', 'resources/js/menu.ts']) }}
<div class="bg-white border border-gray-200 rounded-lg mt-5">
    <div>
        <h4 class="p-4 text-xl font-medium">Manage Widgets</h4>
    </div>

    <div class="p-4">
        @forelse ($this->getWidgetLocations() as $location)
            @livewire('theme::livewire.widget-locations-component', ['location' => $location], key('widget-location-' . $location->name))
        @empty
            <p>No widget locations</p>
        @endforelse
    </div>
</div>
