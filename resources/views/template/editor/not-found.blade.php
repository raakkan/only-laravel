<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 capitalize">
    <x-admin.template.block-header :block="$block" />
    <div class="p-2">
        <p
            class="text-red-500 dark:text-red-400 text-md font-semibold text-center bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            {{ $block->getType() }} {{ $block->getName() }} Not Found
        </p>
    </div>
</div>
