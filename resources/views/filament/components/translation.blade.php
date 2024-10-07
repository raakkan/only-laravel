@php
    use Filament\Support\Facades\FilamentView;

    $containers = $getChildComponentContainers();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    {{-- <x-filament::grid class="gap-4" :default="2"> --}}
    @foreach ($containers as $item)
        {{ $item }}
    @endforeach
    {{-- </x-filament::grid> --}}
</x-dynamic-component>
