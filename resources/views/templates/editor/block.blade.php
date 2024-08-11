<div class="bg-white border border-gray-200 capitalize">
    <x-only-laravel::template.block-header :block="$block" />

    <ul x-sort="handle" class="p-2 space-y-3">
        @forelse ($block->getChildrensByLocation('default') as $blockComponent)
            <livewire:only-laravel::theme.livewire.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()" :key="$blockComponent->getModel()->id . '-' . uniqid()" />
        @empty
            <div class="p-2 text-gray-400 text-center">No components or blocks</div>
        @endforelse

        <x-only-laravel::template.block-drop-container location="default" />
    </ul>
</div>
