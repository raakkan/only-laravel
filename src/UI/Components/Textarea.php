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
        public mixed $labelRight = null,  // New slot for label right content
        // Validations
        public ?string $errorField = null,
        public ?string $errorClass = 'text-red-500 label-text-alt p-1',
        public ?bool $omitError = false,
        public ?bool $firstErrorOnly = false,
    ) {
        $this->uuid = "mary" . md5(serialize($this));
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
            <div>
                @php
                    // We need this extra step to support models arrays. Ex: wire:model="emails.0"  , wire:model="emails.1"
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

                <div class="flex-1 relative">
                    <!-- INPUT -->
                    <textarea
                        placeholder = "{{ $attributes->whereStartsWith('placeholder')->first() }} "

                        {{
                            $attributes
                            ->merge([
                                'id' => $uuid
                            ])
                            ->class([
                                'textarea textarea-primary w-full peer',
                                'pt-5' => ($inline && $label),
                                'border border-dashed' => $attributes->has('readonly') && $attributes->get('readonly') == true,
                                'textarea-error' => $errors->has($errorFieldName())
                            ])
                        }}
                    >{{ $slot }}</textarea>

                    <!-- INLINE LABEL -->
                    @if($label && $inline)
                        <label for="{{ $uuid }}" class="absolute text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 rounded px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-focus:scale-75 peer-focus:-translate-y-3 start-2">
                            {{ $label }}
                        </label>
                    @endif
                </div>

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
