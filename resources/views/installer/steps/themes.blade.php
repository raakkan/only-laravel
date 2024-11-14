<div class="mb-8 bg-purple-100 rounded-xl p-4 sm:p-6">
    <h3 class="text-lg sm:text-xl font-semibold mb-3 text-purple-700">Configure Themes</h3>
    <div class="space-y-4">
        @foreach ($themes as $theme)
            <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                <div class="flex-1">
                    <h4 class="font-medium">{{ $theme->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $theme->description }}</p>
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="text-xs text-gray-500">Version: {{ $theme->version }}</span>
                        <span @class([
                            'px-2 py-0.5 text-xs rounded-full',
                            'bg-green-100 text-green-800' => $theme->is_active,
                            'bg-gray-100 text-gray-800' => !$theme->is_active,
                        ])>
                            {{ $theme->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    @if (!$theme->is_active)
                        <button wire:click="activateTheme('{{ $theme->name }}')" wire:loading.attr="disabled"
                            class="px-3 py-1 text-sm bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 disabled:opacity-50">
                            <span wire:loading.remove wire:target="activateTheme('{{ $theme->name }}')">Activate</span>
                            <span wire:loading wire:target="activateTheme('{{ $theme->name }}')">Loading...</span>
                        </button>
                    @endif
                    @if ($theme->hasUpdate())
                        <button wire:click="updateTheme('{{ $theme->name }}')" wire:loading.attr="disabled"
                            class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 disabled:opacity-50">
                            <span wire:loading.remove wire:target="updateTheme('{{ $theme->name }}')">Update</span>
                            <span wire:loading wire:target="updateTheme('{{ $theme->name }}')">Loading...</span>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
