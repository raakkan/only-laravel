<x-filament::page>
    {{ Vite::useHotFile(storage_path('vite.hot'))->useBuildDirectory('build')->withEntryPoints(['resources/css/base.css', 'resources/js/menu.ts']) }}
    <div class="bg-white rounded-lg p-4">
        <h2 class="text-2xl font-bold mb-4">{{ __('Plugins') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($this->getPlugins() as $plugin)
                <div class="bg-white shadow-md rounded-lg p-4 border">
                    <h3 class="text-lg font-semibold mb-2">{{ $plugin->getLabel() }}</h3>
                    <p class="text-gray-600 mb-4">{{ $plugin->getDescription() }}</p>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ __('Version') }}: {{ $plugin->getVersion() }}</span>

                        <div>
                            @if ($plugin->isActivated())
                                <button wire:click="deactivatePlugin('{{ $plugin->getName() }}')"
                                    class="px-4 py-2 bg-red-500 text-white rounded-md flex items-center"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove>{{ __('Deactivate') }}</span>
                                    <span wire:loading class="inline-block animate-spin mr-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span wire:loading>{{ __('Deactivating...') }}</span>
                                </button>
                            @else
                                <button wire:click="activatePlugin('{{ $plugin->getName() }}')"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md flex items-center"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove>{{ __('Activate') }}</span>
                                    <span wire:loading class="inline-block animate-spin mr-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span wire:loading>{{ __('Activating...') }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::page>
