@php
    $tabsData = $this->getTemplate()->getSettingsTabsData();
    $firstName = $tabsData[0]['name'];
@endphp
<div x-data="{ activeTab: '{{ $firstName }}' }">
    <div class="flex justify-start overflow-x-auto">
        <nav class="flex space-x-4 whitespace-nowrap">
            @foreach ($tabsData as $tab)
                <button class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none"
                    :class="{
                        'bg-gray-500 text-white': activeTab === '{{ $tab['name'] }}',
                        'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== '{{ $tab['name'] }}',
                    }"
                    @click="activeTab = '{{ $tab['name'] }}'">{{ $tab['label'] }}</button>
            @endforeach
        </nav>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 rounded p-2">
        @foreach ($tabsData as $tab)
            <div x-show="activeTab === '{{ $tab['name'] }}'">
                <livewire:only-laravel::template.livewire.block-settings type="{{ $tab['name'] }}" :templateModel="$template"
                    :key="$template->id . '-' . $tab['name'] . '-' . uniqid()" />
            </div>
        @endforeach
    </div>
</div>
