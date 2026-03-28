<x-app-layout>
    <x-slot name="title">
        Добро пожаловать в мир данеток
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Добро пожаловать в мир данеток
        </h2>
    </x-slot>

    @if($isActive)
        <div class=" font-semibold text-2xl mt-8 bg-white rounded-sm shadow-sm border border-gray-200 px-6 py-4 w-full flex flex-col items-center gap-2">
           <a href="/chat" class="hover:underline underline-offset-4 text-accent-600">Идёт игра</a>
        </div>
    @else
        @include('main.timer')    
    @endif

    <div class="mt-8 p-4 space-y-6 w-full bg-white rounded-sm text-gray-700">
        <p>Здесь истории выглядят странно, ответы короткие, а разгадка почти всегда вызывает: «Серьёзно?!»</p>

        <p>Данетка — это короткая загадочная история с логичным объяснением. Твоя задача — докопаться до него, задавая
            вопросы, на которые можно ответить только
            «да», «нет» или «не имеет значения».</p>

        <ul class="list-custom">
            <li>Один вопрос — одна идея</li>
            <li>Логика важнее догадок</li>
            <li>Фантазия приветствуется, но факты решают</li>
        </ul>
    </div>

    {{-- Новые данетки --}}

    <h3 class="my-8 text-center text-2xl text-accent-500 font-semibold">Новые данетки</h3>

    @foreach ($latest as $riddle)
    <div class="mt-4 p-4 space-y-2 w-full bg-white rounded-sm text-gray-700">
        <h4 class=" font-medium text-accent-500">
            <a class="hover:underline underline-offset-4 decoration-accent-300"
                href="{{route('riddles.show',['riddle'=>$riddle]); }}">{{$riddle->title}}
            </a>
        </h4>
        <div class="text-gray-700">
            <a class="hover:underline underline-offset-4 decoration-gray-200"
                href="{{route('riddles.show',['riddle'=>$riddle]); }}">{{$riddle->riddle}}
            </a>
        </div>
        <div class="text-xs text-right">{{$riddle->published_at}}</div>
    </div>
    @endforeach

    <x-slot:sidebar>
        @include('sidebars.basic')
    </x-slot:sidebar>

</x-app-layout>