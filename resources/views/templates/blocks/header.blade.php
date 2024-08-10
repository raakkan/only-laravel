<div>
    @php
        $children = $block->getChildren();
    @endphp

    @foreach ($children as $child)
        {{ $child->render() }}
    @endforeach
</div>
