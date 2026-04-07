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

    <div class="max-w-7xl mx-auto sm:px-6 md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-[minmax(0,3fr)_minmax(0,1fr)] pt-4 md:pt-8">

            <!-- Page Content -->
            <main class="min-w-0 sm:mx-4 md:mr-8 md:ml-0 xl:mr-10 mb-6">
                {{ $slot }}
            </main>

            @isset($sidebar)
                <aside class="sm:mx-4 mb-6 md:mx-0">
                    {{ $sidebar }}
                </aside>
            @endisset

        </div>
    </div>
    
    <div id="myModal" class="fixed flex inset-0 hidden items-center justify-center">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Content -->
        <div class="relative bg-white pt-8 p-6 rounded-md">
            <h2 class="text-xl font-medium text-accent-500">Вы - ведущий игры {{ session('show_modal')?->format('d. m \\в H:i') }}</h2>

        <button id="closeModal"
                class="absolute top-2 right-2 font-bold text-accent-500 hover:text-gray-700 text-3xl shadow-xl leading-none">
            &times;
        </button>

        </div>
    </div>

    @if(session('show_modal'))
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('myModal');

            if (modal) {
                modal.classList.remove('hidden');
            }

            const closeBtn = document.getElementById('closeModal');

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });
            }
        });
    </script>
    @endif
</body>

</html>