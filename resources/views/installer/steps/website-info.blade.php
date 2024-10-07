<div class="mb-8 bg-purple-100 rounded-xl p-4 sm:p-6">
    <h3 class="text-lg sm:text-xl font-semibold mb-3 text-purple-700">Website Information</h3>
    <div class="space-y-4">
        @foreach ([
        'website_name' => 'Website Name',
        'domain' => 'Domain',
        'title' => 'Website Title',
        'meta_description' => 'Meta Description',
        'meta_keywords' => 'Meta Keywords',
    ] as $key => $label)
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <span class="font-medium mb-1 sm:mb-0">{{ $label }}</span>
                @if ($key === 'meta_description')
                    <textarea id="{{ $key }}" wire:model="inputs.{{ $key }}"
                        class="mt-1 block w-full sm:w-48 px-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md bg-white shadow-sm"
                        rows="3"
                        placeholder="Enter {{ $label }}"></textarea>
                @else
                    <input type="text" id="{{ $key }}" wire:model="inputs.{{ $key }}"
                        class="mt-1 block w-full sm:w-48 px-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md bg-white shadow-sm"
                        placeholder="Enter {{ $label }}">
                @endif
            </div>
        @endforeach
    </div>
</div>
