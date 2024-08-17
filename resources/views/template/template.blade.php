@php
    $blocks = $template->getBlocks();
@endphp

@foreach ($blocks as $block)
    {{ $block->render() }}
@endforeach
