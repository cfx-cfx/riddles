<div class="bg-white border-b border-gray-200" x-data="{ navOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-12 items-center justify-between">

            {{-- Левая часть: меню --}}
            <div class="flex items-center gap-2">

                {{-- Кнопка меню (мобилка) --}}
                <button @click="navOpen = !navOpen" class="md:hidden inline-flex items-center justify-center
                           rounded-lg p-2 text-gray-600 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Навигация (десктоп) --}}
                <nav class="hidden md:flex items-center gap-6 font-medium">
                    <a href="{{ route('main') }}" class="relative pb-1 transition {{ request()->routeIs('main')
                        ? 'text-accent-500 after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-accent after:rounded'
                        : 'text-gray-600 hover:text-accent-500' }}">
                        Главная
                    </a>
                    <a href="{{ route('riddles.index') }}" class="relative pb-1 transition {{ request()->routeIs('riddles.index')
                        ? 'text-accent-500 after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-accent after:rounded'
                        : 'text-gray-600 hover:text-accent-500' }}">
                        Все данетки
                    </a>
                    <a href="{{ route('rules') }}" class="relative pb-1 transition {{ request()->routeIs('rules')
                        ? 'text-accent-500 after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-accent after:rounded'
                        : 'text-gray-600 hover:text-accent-500' }}">
                        Правила
                    </a>
                    <a href="{{ route('moderation') }}" class="relative pb-1 transition {{ request()->routeIs('moderation')
                        ? 'text-accent-500 after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-accent after:rounded'
                        : 'text-gray-600 hover:text-accent-500' }}">
                        Авторам и игрокам
                    </a>
                    <a href="{{ route('schedule') }}" class="relative pb-1 transition {{ request()->routeIs('schedule')
                        ? 'text-accent-500 after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-full after:bg-accent after:rounded'
                        : 'text-gray-600 hover:text-accent-500' }}">
                        Расписание игр
                    </a>
                </nav>
            </div>
            @auth
            <div class="relative" x-data="{ open: false }">

                {{-- Кнопка --}}
                <button type="button" class="flex items-center gap-2 text-sm font-medium text-gray-700
               hover:text-accent focus:outline-none" @click="open = !open">

                    <span>{{ Auth::user()->name }}</span>

                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div x-show="open" x-transition @click.outside="open = false"
                    class="absolute right-0 mt-2 bg-white rounded-sm shadow-lg ring-1 ring-black/5 min-w-max -mx-4 sm:-mx-6 md:-mx-8">

                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Профиль
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Выйти
                        </button>
                    </form>
                </div>
            </div>
            @endauth

            @guest
            {{-- Правая часть --}}
            <div class="flex items-center gap-4">

                {{-- Войти — всегда --}}
                <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-accent-500 transition">
                    Войти
                </a>

                {{-- Регистрация — только десктоп --}}
                <a href="{{ route('register') }}" class="font-medium text-gray-600 hover:text-accent-500 transition">
                    Регистрация
                </a>
            </div>
            @endguest

        </div>
    </div>

    {{-- Навигация (мобилка) --}}
    <div x-show="navOpen" x-transition @click.outside="navOpen = false"
        class="md:hidden bg-white border-t border-gray-200">
        <nav class="px-4 py-4 space-y-3 font-medium">
            <a href="{{ route('main') }}" class="block {{ request()->routeIs('main')
                ? 'text-accent-500 font-semibold'
                : 'text-gray-700 hover:text-accent' }}">
                Главная
            </a>
            <a href="{{ route('riddles.index') }}" class="block {{ request()->routeIs('riddles.index')
                ? 'text-accent-500 font-semibold'
                    : 'text-gray-700 hover:text-accent' }}">
                Все данетки
            </a>
            <a href="{{ route('rules') }}" class="block {{ request()->routeIs('rules')
                ? 'text-accent-500 font-semibold'
                : 'text-gray-700 hover:text-accent' }}">
                Правила
            </a>
        </nav>
    </div>
</div>