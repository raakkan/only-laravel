<li x-data="{
    handle: (item, position) => {
        $wire.updateBlockOrder(item, position)
    }
}" x-sort:item="{{ $block->id }}">
    @php
        $blockComponent = $this->getBlock();
    @endphp
    @if ($blockComponent)
        <div class="bg-white border border-gray-200 capitalize">
            <x-only-laravel::template.block-header :block="$blockComponent" />

            @if ($block->type === 'block')
                <ul x-sort="handle" class="p-2 space-y-3">
                    @forelse ($blockComponent->getComponentsByLocation('default') as $blockComponent)
                        <livewire:only-laravel::theme.livewire.block :template="$template" :block="$blockComponent->getModel()"
                            :key="$blockComponent->getModel()->id . '-' . uniqid()" />
                    @empty
                        <div class="p-2 text-gray-400 text-center">No components or blocks</div>
                    @endforelse

                    <x-only-laravel::template.block-drop-container location="default" />
                </ul>
            @endif
        </div>
        <x-filament-actions::modals />
    @endif
</li>
