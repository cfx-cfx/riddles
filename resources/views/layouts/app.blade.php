<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title}}</title>

    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-gray-100">

    <!-- Page Heading -->
    @isset($header) 
        <header class="bg-accent-500 opacity-90 shadow">        
            <div class="flex items-center justify-between">
                    
                {{-- ЛОГО (добавили) --}}
                <a href="/" class="mr-4 shrink-0 flex items-center">
                    <img src="{{ asset('logo.png') }}" class="w-auto h-[64px] sm:h-[72px] bg-white rounded-full shadow-lg mx-4">
                </a>

                <div class="w-full sm:py-6 md:px-8">
                    {{ $header }}
                </div>

            </div>
        </header>
    @endisset

    @include('menu')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-[minmax(0,3fr)_minmax(0,1fr)] gap-8">

            <!-- Page Content -->
            <main class="min-w-0">
                {{ $slot }}
            </main>

            @isset($sidebar)
            <aside class="lg:col-span-1">
                {{ $sidebar }}
            </aside>
            @endisset

        </div>
    </div>
</body>

</html>