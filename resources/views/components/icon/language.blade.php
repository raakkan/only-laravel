@props(['locale'])

@php
    $iconPath = __DIR__ . '/../../../../svg/language-' . $locale . '.svg';
    $iconUrl = asset($iconPath);

    dd(__DIR__);
@endphp

<img src="{{ $iconUrl }}" alt="{{ $locale }} flag" {{ $attributes->merge(['class' => 'language-icon']) }}>
