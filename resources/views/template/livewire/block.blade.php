<li x-data="{
    handle: (item, position) => {
        $wire.updateBlockOrder(item, position)
    }
}" x-sort:item="{{ $block->id }}"
    x-on:block-settings-saved.window="if (event.detail.id === {{ $block->id }}) { $wire.$refresh(); }">
    @php
        $blockComponent = $this->getBlock();
    @endphp
    @if ($blockComponent)
        {{ $blockComponent->editorRender() }}
        <x-filament-actions::modals />
    @endif
</li>
