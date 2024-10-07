<div class="grid-block {{ $block->getBackgroundClasses() }}">
    <div class="container mx-auto">
        <div class="grid gap-4 {{ $block->getGridClasses() }}">
            @foreach (range(1, $block->columns->value) as $index)
                <div class="{{ $block->columns->getColumnClasses()[0] }}">
                    @foreach ($block->getChildrenByLocation('column-' . $index) as $childBlock)
                        {!! $childBlock->render() !!}
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
