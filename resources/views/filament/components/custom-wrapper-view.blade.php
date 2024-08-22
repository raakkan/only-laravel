@props([
    'id',
    'label' => null,
    'labelSrOnly' => false,
    'helperText' => null,
    'hint' => null,
    'hintIcon' => null,
    'required' => false,
    'statePath',
])

<div {{ $attributes->class(['custom-wrapper-class']) }}>
    hhhh
    <div class="custom-wrapper-header">
        @if ($label && !$labelSrOnly)
            <label for="{{ $id }}" class="font-bold">
                {{ $label }}
                @if ($required)
                    <span class="text-danger-600 dark:text-danger-400">*</span>
                @endif
            </label>
        @endif

        @if ($hint || $hintIcon)
            <div class="custom-wrapper-hint">
                @if ($hintIcon)
                    <i class="{{ $hintIcon }} mr-1"></i>
                @endif
                @if ($hint)
                    {{ $hint }}
                @endif
            </div>
        @endif
    </div>

    {{ $slot }}

    @if ($helperText)
        <div class="custom-wrapper-helper-text">
            {{ $helperText }}
        </div>
    @endif
</div>
