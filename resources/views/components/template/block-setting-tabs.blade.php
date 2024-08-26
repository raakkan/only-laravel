@props(['data', 'activeTab', 'templateModel', 'block'])

<div x-data="{ activeTab: '{{ $activeTab }}' }">
    <div class="flex flex-wrap border-b border-gray-200 text-sm font-semibold rounded-t-lg w-full  bg-gray-100">
        @foreach ($data as $tab)
            <button class="p-2 rounded focus:outline-none bg-gray-100"
                :class="{ 'bg-white': activeTab === '{{ $tab['name'] }}' }"
                @click="activeTab = '{{ $tab['name'] }}'"">{{ $tab['label'] }}</button>
        @endforeach

    </div>

    <div class="mt-3 bg-white dark:bg-gray-800 rounded p-2">
        @foreach ($data as $tab)
            <div x-show="activeTab === '{{ $tab['name'] }}'">
                @if (isset($templateModel))
                    <livewire:only-laravel::template.livewire.block-settings type="{{ $tab['name'] }}" :templateModel="$templateModel"
                        :key="$templateModel->id . '-' . $tab['name'] . '-' . uniqid()" />
                @else
                    <livewire:only-laravel::template.livewire.block-settings type="{{ $tab['name'] }}" :blockModel="$block->getModel()"
                        :key="$block->getName() . '-' . uniqid()" />
                @endif
            </div>
        @endforeach
    </div>
</div>
