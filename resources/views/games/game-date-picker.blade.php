<x-app-layout>
    <x-slot name="title">
        Добро пожаловать в мир данеток
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Админка
        </h2>
    </x-slot> 

    <h3 class="my-8 text-center text-2xl text-accent-500 font-semibold">Выберите дату игры</h3>
    <form method="POST" action="/games/host/store">
        @csrf
        <div class="flex gap-2">        
            <select id="starts_at" name="id" class="w-full rounded-sm border-gray-300">
                @foreach($games as $game)
                    <option value="{{ $game->id }}">{{ $game->starts_at }}</option>
                @endforeach
            </select>
            <input type="submit" value="Выбрать" 
                class="px-4 py-1 rounded-lg border border-accent-600
                    bg-accent-500 text-white font-semibold opacity-90
                    hover:opacity-100">
        </div>
    </form>

    @if (session('status') && session('status')==='Ok')
        <div class="p-2 font-medium text-xl text-emerald-600">
            <div>Вы выбрали вести игру, которая начнется {{session('date') }} в {{session('time') }}</div>
            <div>Панель ведущего появится в вашем чате за 10 минут до начала игры.</div>
            <div>Пожалуйста, начните игру строго по расписанию.</div>
        </div>
    @endif

</x-app-layout>
