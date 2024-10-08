@php
    $blocks = $template->getBlocks();
@endphp

<body style="{{ $template->getCustomStyle() }}" class="{{ $template->getCustomCss() }}">
    {!! setting('onlylaravel.global_insert.body_script') !!}
    @foreach ($blocks as $block)
        {{ $block->render() }}
    @endforeach
</body>
