<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 capitalize">
    <x-admin.template.block-header :block="$block" />
    @if (!$block->isDisabled() && $block->isAcceptDropChild())
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
