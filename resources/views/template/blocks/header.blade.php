<header class="{{ $block->getCustomCss() }}" style="{{ $block->getCustomStyle() }}">
    @php
        $childrens = $block->getChildren();
    @endphp

    @foreach ($childrens as $child)
        {!! $child->render() !!}
    @endforeach
</header>
