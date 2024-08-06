<div class="bg-white border border-gray-200">
    @php
        $blockComponent = $this->getBlock();
    @endphp
    <x-only-laravel::template.block-header :block="$blockComponent" />

    @if ($block->type === 'block')
        <div class="p-2 space-y-3">
            @forelse ($blockComponent->getComponentsByLocation('default') as $blockComponent)
                <livewire:only-laravel::theme.livewire.block :block="$blockComponent->getModel()" :key="$blockComponent->getModel()->id . '-' . uniqid()" />
            @empty
                <div class="p-2 text-gray-400 text-center">No components or blocks</div>
            @endforelse

            <x-only-laravel::template.block-drop-container location="default" />
        </div>
    @endif

</div>
