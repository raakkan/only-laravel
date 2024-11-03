<?php

namespace Raakkan\OnlyLaravel\UI\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?string $hintClass = 'label-text-alt text-gray-400 py-1 pb-0',
        public ?bool $inline = false,
        public mixed $labelRight = null,
        // Validations
        public ?string $errorField = null,
        public ?string $errorClass = 'text-red-500 label-text-alt p-1',
        public ?bool $omitError = false,
        public ?bool $firstErrorOnly = false,
    ) {
        $this->uuid = 'mary'.md5(serialize($this));
    }

    public function modelName(): ?string
    {
        return $this->attributes->whereStartsWith('wire:model')->first();
    }

    public function errorFieldName(): ?string
    {
        return $this->errorField ?? $this->modelName();
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div wire:key="{{ $uuid }}" x-data="{ isFullscreen: false }">
                @php
                    $uuid = $uuid . $modelName()
                @endphp

                <!-- STANDARD LABEL -->
                @if($label && !$inline)
                    <div class="flex justify-between items-center">
                        <label for="{{ $uuid }}" class="pt-0 label label-text font-semibold">
                            <span>
                                {{ $label }}
                                @if($attributes->get('required'))
                                    <span class="text-error">*</span>
                                @endif
                            </span>
                        </label>
                        @if($labelRight)
                            <div class="text-sm text-gray-500">
                                {{ $labelRight }}
                            </div>
                        @endif
                    </div>
                @endif

                <div class="relative">
                    <!-- Regular Textarea -->
                    <textarea
                        placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                        {{
                            $attributes
                            ->merge([
                                'id' => $uuid
                            ])
                            ->class([
                                'textarea textarea-primary w-full peer',
                                'pt-5' => ($inline && $label),
                                'border border-dashed' => $attributes->has('readonly') && $attributes->get('readonly') == true,
                                'textarea-error' => $errors->has($errorFieldName()),
                            ])
                        }}
                    >{{ $slot }}</textarea>

                    <!-- Fullscreen Button -->
                    <button
                        type="button"
                        @click="isFullscreen = true"
                        class="absolute right-2 top-2 z-10 p-1 hover:bg-gray-100 rounded"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                        </svg>
                    </button>

                    <!-- INLINE LABEL -->
                    @if($label && $inline)
                        <label for="{{ $uuid }}" class="absolute text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 rounded px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-focus:scale-75 peer-focus:-translate-y-3 start-2">
                            {{ $label }}
                        </label>
                    @endif
                </div>

                <!-- Fullscreen Modal -->
                <template x-if="isFullscreen">
                    <div class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <!-- Background overlay -->
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="isFullscreen = false"></div>

                            <!-- Modal panel -->
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-full h-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 h-full">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $label }}</h3>
                                        <button @click="isFullscreen = false" class="text-gray-400 hover:text-gray-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <textarea
                                        {{ $attributes }}
                                        class="w-full h-[calc(100vh-12rem)] resize-none border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                        placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                                    >{{ $slot }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- ERROR -->
                @if(!$omitError && $errors->has($errorFieldName()))
                    @foreach($errors->get($errorFieldName()) as $message)
                        @foreach(Arr::wrap($message) as $line)
                            <div class="{{ $errorClass }}" x-classes="text-red-500 label-text-alt p-1">{{ $line }}</div>
                            @break($firstErrorOnly)
                        @endforeach
                        @break($firstErrorOnly)
                    @endforeach
                @endif

                <!-- HINT -->
                @if($hint)
                    <div class="{{ $hintClass }}" x-classes="label-text-alt text-gray-400 py-1 pb-0">{{ $hint }}</div>
                @endif
            </div>
        HTML;
    }
}
