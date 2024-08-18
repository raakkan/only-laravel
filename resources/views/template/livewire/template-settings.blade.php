<div x-data="{ activeTab: {{ $this->getTemplate()->hasSettings() ? '"settings"' : '"maxWidth"' }} }">
    <div class="flex justify-start overflow-x-auto">
        <nav class="flex space-x-4 whitespace-nowrap">
            @if ($this->getTemplate()->hasSettings())
                <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                    :class="{
                        'bg-blue-500 text-white': activeTab === 'settings',
                        'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'settings'
                    }"
                    @click="activeTab = 'settings'">Settings</button>
            @endif
            <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                :class="{
                    'bg-blue-500 text-white': activeTab === 'maxWidth',
                    'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'maxWidth'
                }"
                @click="activeTab = 'maxWidth'">Max width</button>
            <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                :class="{
                    'bg-blue-500 text-white': activeTab === 'spacing',
                    'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'spacing'
                }"
                @click="activeTab = 'spacing'">Spacing</button>
            <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                :class="{
                    'bg-blue-500 text-white': activeTab === 'color',
                    'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'color'
                }"
                @click="activeTab = 'color'">Color</button>
            <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                :class="{
                    'bg-blue-500 text-white': activeTab === 'text',
                    'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'text'
                }"
                @click="activeTab = 'text'">Text</button>
        </nav>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 rounded p-2">
        @if ($this->getTemplate()->hasSettings())
            <div x-show="activeTab === 'settings'">
                {{ $this->settingsForm }}
                <div class="flex justify-end mt-5">
                    <x-filament::button wire:click="save('settingsForm')">
                        Save
                    </x-filament::button>
                </div>
            </div>
        @endif
        <div x-show="activeTab === 'maxWidth'">
            {{ $this->maxWidthForm }}
            <div class="flex justify-end mt-5">
                <x-filament::button wire:click="save('maxWidthForm')">
                    Save
                </x-filament::button>
            </div>
        </div>
        <div x-show="activeTab === 'spacing'">
            {{ $this->spacingForm }}
            <div class="flex justify-end mt-5">
                <x-filament::button wire:click="save('spacingForm')">
                    Save
                </x-filament::button>
            </div>
        </div>
        <div x-show="activeTab === 'color'">
            {{ $this->colorForm }}
            <div class="flex justify-end mt-5">
                <x-filament::button wire:click="save('colorForm')">
                    Save
                </x-filament::button>
            </div>
        </div>
        <div x-show="activeTab === 'text'">
            {{ $this->textForm }}
            <div class="flex justify-end mt-5">
                <x-filament::button wire:click="save('textForm')">
                    Save
                </x-filament::button>
            </div>
        </div>
    </div>
</div>
