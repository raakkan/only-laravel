@props([
    'color' => 'bg-blue-500 text-white',
    'wireTarget' => '',
    'icon' => false,
    'disabled' => false,
    'size' => 'md',
])

@php
    $sizeClasses = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2',
        'lg' => 'px-5 py-2.5 text-lg',
    ][$size];
@endphp

<button
    {{ $attributes->merge(['class' => 'flex items-center rounded-md disabled:opacity-50 disabled:cursor-not-allowed ' . $color . ' ' . $sizeClasses]) }}
    wire:loading.attr="disabled" wire:target="{{ $wireTarget }}" {{ $disabled ? 'disabled' : '' }}>
    @if ($icon)
        <span class="mr-2">
            <x-dynamic-component :component="$icon" class="h-5 w-5" />
        </span>
    @endif
    @if ($wireTarget)
        <span wire:loading wire:target="{{ $wireTarget }}" class="mr-2">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </span>
    @endif
    {{ $slot }}
</button>
