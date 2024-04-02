<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @include('layouts/sections/styles')

    @include('layouts/sections/scripts')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles


</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-zinc-100">

        @php
            $route = Route::getRoutes()->getByAction(request()->route()->getActionName());
        @endphp

        @if (Auth::user() && $route && in_array('auth:sanctum', $route->gatherMiddleware()))
            <x-sidebar>
                <x-slot name="content">
                    <!-- Page Content -->
                    <div>
                        {{ $slot }}
                    </div>
                </x-slot>
            </x-sidebar>
        @else
            @livewire('navigation-menu')
            <main>
                {{ $slot }}
            </main>
        @endif
    </div>

    @stack('modals')

    @livewireScripts

    @stack('js')

    <script type="text/javascript">
        Livewire.on('alert', function(message) {
            Swal.fire(
                'Mensaje del sistema',
                message,
                'success'
            )
        });
        AOS.init();

    </script>

    <!-- Page Scripts -->
    @yield('page-script')
</body>

</html>
