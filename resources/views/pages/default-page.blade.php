<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data :class="$store.darkMode.on && 'dark'"
    :data-theme="$store.darkMode.on && 'dark'">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    @php
        $pageTemplate = $page->template->getPageTemplate();
    @endphp

    {{-- @if ($pageTemplate->getIncludeCoreFiles())
        @vite(['/../../../../../resources/css/app.css', '/../../../../../resources/js/app.js'])
    @endif --}}

    {!! $pageTemplate->getCustomFilesWithTags() !!}

    {!! $pageTemplate->getCustomScript() !!}

</head>

{{ $pageTemplate->render() }}

</html>
