<div>
    @php
        $childrens = $block->getChildrens();
    @endphp

    @foreach ($childrens as $child)
        {{ $child->render() }}
    @endforeach
</div>
