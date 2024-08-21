<div class="bg-white border border-gray-200 capitalize">
    @php
        $navigationStartComponent = collect($block->getChildrenByLocation('navigation-start'))->first();
        $navigationCenterComponent = collect($block->getChildrenByLocation('navigation-center'))->first();
        $navigationEndComponent = collect($block->getChildrenByLocation('navigation-end'))->first();
    @endphp
    <x-only-laravel::template.block-header :block="$block" />
    <div class="flex flex-row justify-between w-full">
        @if ($block->showStartComponent())
            <div class="w-full">
                <div class="p-2 text-gray-500 text-md font-semibold text-center bg-white border-b">
                    Start</div>
                <div class="p-2">
                    @if ($navigationStartComponent)
                        <ul>
                            <livewire:only-laravel::template.livewire.block :template="$navigationStartComponent->getTemplateModel()" :block="$navigationStartComponent->getModel()"
                                :key="$navigationStartComponent->getModel()->id . '-' . uniqid()" />
                        </ul>
                    @else
                        <x-only-laravel::template.block-drop-container location="navigation-start" componentOnly />
                    @endif
                </div>
            </div>
        @endif
        @if ($block->showCenterComponent())
            <div class="w-full">
                <div class="p-2 text-gray-500 text-md font-semibold text-center bg-white border-b">
                    Center</div>
                <div class="p-2">
                    @if ($navigationCenterComponent)
                        <ul>
                            <livewire:only-laravel::template.livewire.block :template="$navigationCenterComponent->getTemplateModel()" :block="$navigationCenterComponent->getModel()"
                                :key="$navigationCenterComponent->getModel()->id . '-' . uniqid()" />
                        </ul>
                    @else
                        <x-only-laravel::template.block-drop-container location="navigation-center" componentOnly />
                    @endif
                </div>
            </div>
        @endif
        @if ($block->showEndComponent())
            <div class="w-full">
                <div class="p-2 text-gray-500 text-md font-semibold text-center bg-white border-b">
                    End</div>
                <div class="p-2">
                    @if ($navigationEndComponent)
                        <ul>
                            <livewire:only-laravel::template.livewire.block :template="$navigationEndComponent->getTemplateModel()" :block="$navigationEndComponent->getModel()"
                                :key="$navigationEndComponent->getModel()->id . '-' . uniqid()" />
                        </ul>
                    @else
                        <x-only-laravel::template.block-drop-container location="navigation-end" componentOnly />
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
