<div>
    @foreach ($block->getMenu()->getItems() as $item)
        <a href="{{ $item->getUrl() }}" target="{{ $item->getTarget() }}">{{ $item->getLabel() }}</a>
    @endforeach
</div>
