{{-- Форма поиска --}}
<div class="my-8 p-4  w-full bg-white rounded-md">
    <h2 class="mb-2 text-accent-500 text-center text-lg font-medium">Найти данетку</h2>
    <form method="GET" action="{{ route('search') }}">
        {{-- Input с лупой внутри --}}
        <div class="relative">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск" autocomplete="off" class="w-full rounded-lg border border-gray-300 bg-gray-100
                   py-1 pl-5 pr-12
                   text-gray-900 placeholder-gray-400">

            {{-- Лупа (НЕ кнопка) --}}
            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.75 3.75a7.5 7.5 0 0012.9 12.9z" />
                </svg>
            </span>
        </div>

        {{-- Кнопка submit под input --}}
        <x-sidebar-button>
            Найти
        </x-sidebar-button>
    </form>
</div>

{{-- Сссылка добавить данетку --}}
@if(!request()->routeIs('riddles.create'))
@auth
<div class="my-4 p-4 space-y-6 w-full bg-white rounded-md text-gray-700">
    Если вы знаете данетки, которых здесь нет, пожалуйста, добавьте их на сайт.
    <x-sidebar-reference href="{{route('riddles.create')}}">
        Добавить
    </x-sidebar-reference>
</div>
@endauth
@endif