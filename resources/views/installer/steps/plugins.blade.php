<div class="mb-8 bg-purple-100 rounded-xl p-4 sm:p-6">
    <h3 class="text-lg sm:text-xl font-semibold mb-3 text-purple-700">Configure Plugins</h3>
    <div class="space-y-4">
        @foreach ($plugins as $plugin)
            <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                <div class="flex-1">
                    <h4 class="font-medium">{{ $plugin->label }}</h4>
                    <p class="text-sm text-gray-600">{{ $plugin->description }}</p>
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="text-xs text-gray-500">Version: {{ $plugin->version }}</span>
                        <span @class([
                            'px-2 py-0.5 text-xs rounded-full',
                            'bg-green-100 text-green-800' => $plugin->is_active,
                            'bg-gray-100 text-gray-800' => !$plugin->is_active,
                        ])>
                            {{ $plugin->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    @if ($plugin->is_active)
                        <button wire:click="deactivatePlugin('{{ $plugin->name }}')" wire:loading.attr="disabled"
                            class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-md hover:bg-red-200 disabled:opacity-50">
                            <span wire:loading.remove
                                wire:target="deactivatePlugin('{{ $plugin->name }}')">Deactivate</span>
                            <span wire:loading wire:target="deactivatePlugin('{{ $plugin->name }}')">Loading...</span>
                        </button>
                    @else
                        <button wire:click="activatePlugin('{{ $plugin->name }}')" wire:loading.attr="disabled"
                            class="px-3 py-1 text-sm bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 disabled:opacity-50">
                            <span wire:loading.remove
                                wire:target="activatePlugin('{{ $plugin->name }}')">Activate</span>
                            <span wire:loading wire:target="activatePlugin('{{ $plugin->name }}')">Loading...</span>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
