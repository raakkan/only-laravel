<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 capitalize">
    <x-admin.template.block-header :block="$block" />

    @if ($block->sidebar)
        <div class="flex flex-wrap w-full">
            @if ($block->sidebarPosition->value === 'left' || $block->sidebarPosition->value === 'both')
                <div class="w-full {{ $block->sidebarPosition->value === 'both' ? 'md:w-1/3' : 'md:w-1/2' }}">
                    <div
                        class="p-2 text-gray-500 dark:text-gray-400 text-md font-semibold text-center bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        Left Sidebar</div>
                    <ul x-sort="handle" class="p-2 space-y-3">
                        @forelse ($block->getChildrenByLocation('left-sidebar') as $blockComponent)
                            <livewire:admin.appearance.template.components.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()"
                                :key="$blockComponent->getModel()->id . '-' . uniqid()" />
                        @empty
                            <li class="p-2 text-gray-400 dark:text-gray-500 text-center">No components or blocks</li>
                        @endforelse
                        @if ($block->isReal())
                            <x-admin.template.block-drop-container location="left-sidebar" />
                        @endif
                    </ul>
                </div>
            @endif

            <div class="w-full {{ $block->sidebarPosition->value === 'both' ? 'md:w-1/3' : 'md:w-1/2' }}">
                <div
                    class="p-2 text-gray-500 dark:text-gray-400 text-md font-semibold text-center bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    Content</div>
                <ul x-sort="handle" class="p-2 space-y-3">
                    @forelse ($block->getChildrenByLocation('default') as $blockComponent)
                        <livewire:admin.appearance.template.components.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()"
                            :key="$blockComponent->getModel()->id . '-' . uniqid()" />
                    @empty
                        <li class="p-2 text-gray-400 dark:text-gray-500 text-center">No components or blocks</li>
                    @endforelse
                    @if ($block->isReal())
                        <x-admin.template.block-drop-container location="default" />
                    @endif
                </ul>
            </div>

            @if ($block->sidebarPosition->value === 'right' || $block->sidebarPosition->value === 'both')
                <div class="w-full {{ $block->sidebarPosition->value === 'both' ? 'md:w-1/3' : 'md:w-1/2' }}">
                    <div
                        class="p-2 text-gray-500 dark:text-gray-400 text-md font-semibold text-center bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        Right Sidebar</div>
                    <ul x-sort="handle" class="p-2 space-y-3">
                        @forelse ($block->getChildrenByLocation('right-sidebar') as $blockComponent)
                            <livewire:admin.appearance.template.components.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()"
                                :key="$blockComponent->getModel()->id . '-' . uniqid()" />
                        @empty
                            <li class="p-2 text-gray-400 dark:text-gray-500 text-center">No components or blocks</li>
                        @endforelse
                        @if ($block->isReal())
                            <x-admin.template.block-drop-container location="right-sidebar" />
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    @else
        <ul x-sort="handle" class="p-2 space-y-3">
            @forelse ($block->getChildrenByLocation('default') as $blockComponent)
                <livewire:admin.appearance.template.components.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()"
                    :key="$blockComponent->getModel()->id . '-' . uniqid()" />
            @empty
                <div class="p-2 text-gray-400 dark:text-gray-500 text-center">No components or blocks</div>
            @endforelse
            @if ($block->isReal())
                <x-admin.template.block-drop-container location="default" />
            @endif
        </ul>
    @endif
</div>
