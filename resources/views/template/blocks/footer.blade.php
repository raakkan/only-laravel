<footer class="{{ $block->getCustomCss() }}  {{ $block->getTemplateModel()->getContainerCssClasses() }}"
    style="{{ $block->getCustomStyle() }}">
    {!! setting('onlylaravel.global_insert.footer_script') !!}
    @php
        $childrens = $block->getChildren();
    @endphp

    @foreach ($childrens as $child)
        {{ $child->render() }}
    @endforeach
</footer>
