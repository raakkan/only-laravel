<div class="bg-white border border-gray-200 capitalize">
    <x-only-laravel::template.block-header :block="$block" />

    <div class="grid gap-4 {{ $block->getGridClasses() }}">
        @foreach (range(1, $block->columns->value) as $i)
            <div class="{{ $block->columns->getColumnClasses()[0] }}">
                <div class="p-2 text-gray-500 text-md font-semibold text-center bg-white border-b">
                    Column {{ $i }}
                </div>
                <ul x-sort="handle" class="p-2 space-y-3">
                    @forelse ($block->getChildrenByLocation('column-' . $i) as $blockComponent)
                        <livewire:only-laravel::template.livewire.block :template="$blockComponent->getTemplateModel()" :block="$blockComponent->getModel()"
                            :key="$blockComponent->getModel()->id . '-' . uniqid()" />
                    @empty
                        <li class="p-2 text-gray-400 text-center">No components or blocks</li>
                    @endforelse
                    <x-only-laravel::template.block-drop-container location="column-{{ $i }}" />
                </ul>
            </div>
        @endforeach
    </div>
</div>
