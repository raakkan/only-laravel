<div class="bg-white border border-gray-200 capitalize">
    <x-only-laravel::template.block-header :block="$block" />

    @if ($block->sidebar)
        <div class="flex flex-wrap w-full">
            @if ($block->sidebarPosition->value === 'left' || $block->sidebarPosition->value === 'both')
                <div class="w-full {{ $block->sidebarPosition->value === 'both' ? 'md:w-1/3' : 'md:w-1/2' }}">
                    <div class="p-2 text-gray-500 text-md font-semibold text-center bg-white border-b">Left Sidebar</div>
                    <ul x-sort="handle" class="p-2 space-y-3">
                        @forelse ($block->getChildrensByLocation('left-sidebar') as $blockComponent)
                            <livewire:only-laravel::theme.livewire.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()"
                                :key="$blockComponent->getModel()->id . '-' . uniqid()" />
                        @empty
                            <li class="p-2 text-gray-400 text-center">No components or blocks</li>
                        @endforelse
                        <x-only-laravel::template.block-drop-container location="left-sidebar" />
                    </ul>
                </div>
            @endif

            <div class="w-full {{ $block->sidebarPosition->value === 'both' ? 'md:w-1/3' : 'md:w-1/2' }}">
                <div
                    class="p-2 text-gray-500 text-md font-semibold text-center bg-white border-b {{ $block->sidebarPosition === 'right' ? 'border-r' : 'border-l' }}">
                    Content</div>
                <ul x-sort="handle" class="p-2 space-y-3">
                    @forelse ($block->getChildrensByLocation('default') as $blockComponent)
                        <livewire:only-laravel::theme.livewire.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()"
                            :key="$blockComponent->getModel()->id . '-' . uniqid()" />
                    @empty
                        <li class="p-2 text-gray-400 text-center">No components or blocks</li>
                    @endforelse
                    <x-only-laravel::template.block-drop-container location="default" />
                </ul>
            </div>

            @if ($block->sidebarPosition->value === 'right' || $block->sidebarPosition->value === 'both')
                <div class="w-full {{ $block->sidebarPosition->value === 'both' ? 'md:w-1/3' : 'md:w-1/2' }}">
                    <div class="p-2 text-gray-500 text-md font-semibold text-center bg-white border-b">Right Sidebar
                    </div>
                    <ul x-sort="handle" class="p-2 space-y-3">
                        @forelse ($block->getChildrensByLocation('right-sidebar') as $blockComponent)
                            <livewire:only-laravel::theme.livewire.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()"
                                :key="$blockComponent->getModel()->id . '-' . uniqid()" />
                        @empty
                            <li class="p-2 text-gray-400 text-center">No components or blocks</li>
                        @endforelse
                        <x-only-laravel::template.block-drop-container location="right-sidebar" />
                    </ul>
                </div>
            @endif
        </div>
    @else
        <ul x-sort="handle" class="p-2 space-y-3">
            @forelse ($block->getChildrensByLocation('default') as $blockComponent)
                <livewire:only-laravel::theme.livewire.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()" :key="$blockComponent->getModel()->id . '-' . uniqid()" />
            @empty
                <div class="p-2 text-gray-400 text-center">No components or blocks</div>
            @endforelse
            <x-only-laravel::template.block-drop-container location="default" />
        </ul>
    @endif
</div>
