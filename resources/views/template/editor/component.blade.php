<div class="bg-white border border-gray-200 capitalize">
    <x-only-laravel::template.block-header :block="$block" />
    {{ $block->render() }}
</div>
