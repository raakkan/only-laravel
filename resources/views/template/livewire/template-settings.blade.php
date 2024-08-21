<div x-data="{ activeTab: {{ $this->getTemplate()->hasSettings() ? '"settings"' : '"maxWidth"' }} }">
    <div class="flex justify-start overflow-x-auto">
        <nav class="flex space-x-4 whitespace-nowrap">
            @if ($this->getTemplate()->hasSettings())
                <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                    :class="{
                        'bg-gray-500 text-white': activeTab === 'settings',
                        'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'settings'
                    }"
                    @click="activeTab = 'settings'">Settings</button>
            @endif
            <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                :class="{
                    'bg-gray-500 text-white': activeTab === 'maxWidth',
                    'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'maxWidth'
                }"
                @click="activeTab = 'maxWidth'">Max width</button>
            <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                :class="{
                    'bg-gray-500 text-white': activeTab === 'spacing',
                    'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'spacing'
                }"
                @click="activeTab = 'spacing'">Spacing</button>
            <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                :class="{
                    'bg-gray-500 text-white': activeTab === 'color',
                    'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'color'
                }"
                @click="activeTab = 'color'">Color</button>
            <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                :class="{
                    'bg-gray-500 text-white': activeTab === 'text',
                    'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'text'
                }"
                @click="activeTab = 'text'">Text</button>
        </nav>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 rounded p-2">
        @if ($this->getTemplate()->hasSettings())
            <div x-show="activeTab === 'settings'">
                {{ $this->form }}
                <div class="flex justify-end mt-5">
                    <x-filament::button wire:click="save">
                        Save
                    </x-filament::button>
                </div>
            </div>
        @endif
        <div x-show="activeTab === 'maxWidth'">
            <livewire:only-laravel::template.livewire.max-width-settings :templateModel="$template" :key="$template->id . '-' . uniqid()" />
        </div>
        <div x-show="activeTab === 'spacing'">
            <livewire:only-laravel::template.livewire.spacing-settings :templateModel="$template" :key="$template->id . '-' . uniqid()" />
        </div>
        <div x-show="activeTab === 'color'">
            <livewire:only-laravel::template.livewire.block-color-settings :templateModel="$template" :key="$template->id . '-' . uniqid()" />
        </div>
        <div x-show="activeTab === 'text'">
            <livewire:only-laravel::template.livewire.block-text-settings :templateModel="$template" :key="$template->id . '-' . uniqid()" />
        </div>
    </div>
</div>
