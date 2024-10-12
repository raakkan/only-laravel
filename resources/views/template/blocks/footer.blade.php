<footer class="{{ $block->getCustomCss() }}" style="{{ $block->getCustomStyle() }}">
    {!! setting('onlylaravel.global_insert.footer_script') !!}
    @php
        $childrens = $block->getChildren();
    @endphp

    <div class="{{ $block->getTemplateModel()->getContainerCssClasses() }}">
        @foreach ($childrens as $child)
            {{ $child->render() }}
        @endforeach
    </div>
</footer>
