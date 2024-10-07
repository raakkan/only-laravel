<style>
    {{ $block->getBackgroundStyles() }}
</style>
<div class="{{ $block->getName() }} {{ $block->getCustomCss() }} template-container {{ $block->getBackgroundClasses() }}"
    style="{{ $block->getBackgroundImageStyles() }} {{ $block->getCustomStyle() }}">
    @php
        $childrens = $block->getChildren();
    @endphp

    @foreach ($childrens as $child)
        {{ $child->render() }}
    @endforeach
</div>
