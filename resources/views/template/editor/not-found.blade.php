<div class="bg-white border border-gray-200 capitalize">
    <x-only-laravel::template.block-header :block="$block" />
    <div class="p-2">
        <p class="text-red-500 text-md font-semibold text-center bg-white border-b">{{ $block->getType() }}
            {{ $block->getName() }} Not Found</p>
    </div>
</div>
