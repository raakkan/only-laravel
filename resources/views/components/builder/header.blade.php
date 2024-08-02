@props(['title'])
<div class="flex items-center justify-between p-2 border-b">
    <div class="flex items-center">
        <x-filament::icon icon="heroicon-m-bars-3" class="w-5 h-5 text-gray-400 mr-3" />
        <h2 class="text-md font-bold">{{ $title }}</h2>
    </div>
    <div>
        <x-filament::icon-button icon="heroicon-m-trash" @click="console.log('test')" label="New label" />
    </div>
</div>
