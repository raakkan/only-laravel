<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/installer/installer.css') }}" rel="stylesheet">

    <title>{{ $title ?? config('app.name') }} - Installer</title>
</head>

<body
    class="min-h-screen overscroll-y-none bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white">
    {{ $slot }}

    @stack('scripts')
</body>

</html>
