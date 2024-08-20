<div>
    @php
        $childrens = $block->getChildren();
    @endphp

    @foreach ($childrens as $child)
        {{ $child->render() }}
    @endforeach
</div>
