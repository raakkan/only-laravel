<header class="p-4">
    @php
        $childrens = $block->getChildren();
    @endphp

    @foreach ($childrens as $child)
        {{ $child->render() }}
    @endforeach
</header>
