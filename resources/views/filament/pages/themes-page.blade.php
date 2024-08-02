<x-filament::page>
    <script src="https://cdn.tailwindcss.com"></script>
    <div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @php
                $themes = $this->getThemes();
                $activeTheme = $this->getActiveTheme();
            @endphp

            @foreach ($themes as $theme)
                <div class="bg-white shadow rounded-lg p-4 relative">
                    <div class="w-full h-40 bg-gray-200 mb-4 rounded flex items-center justify-center">
                        <span class="text-gray-500">No screenshot available</span>
                    </div>

                    <h3 class="text-lg font-semibold">{{ $theme->getName() }}</h3>
                    <p class="text-sm text-gray-600">{{ $theme->getDescription() }}</p>
                    <p class="text-xs text-gray-500 mt-2">Version: {{ $theme->getVersion() }}</p>

                    @if ($activeTheme && $theme->getName() === $activeTheme->getName())
                        <span
                            class="absolute top-2 right-2 bg-green-500 white text-xs font-bold px-2 py-1 rounded">Active</span>
                    @else
                        <button wire:click="activateTheme('{{ $theme->getName() }}', '{{ $theme->getVendor() }}')"
                            wire:loading.attr="disabled"
                            class="mt-4 bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold py-1 px-3 rounded flex items-center justify-center">
                            <svg wire:loading class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove>Activate</span>
                            <span wire:loading>Loading...</span>
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($themes->isEmpty())
            <p class="text-center text-gray-500 mt-4">No themes found matching your search.</p>
        @endif
    </div>
</x-filament::page>
