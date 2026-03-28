<x-app-layout>
    <x-slot name="title">
        {{$riddle->title}}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{$riddle->title}}
        </h2>
    </x-slot>

    <div class="mt-8 py-2 px-6 space-y-6 w-full bg-white rounded-sm">
        <div class="text-red-600 font-semibold">{{session('message') }}</div>
        @can('adminOrAuthor')
            <h4 class=" font-medium text-accent-500">{{$riddle->status->label()}}</h4>
        @endcan
        <div>{{$riddle->riddle}}</div>
        @can('adminOrAuthor', $riddle)
        <div class="text-accent-500 px-4">{{$riddle->solution_text}}</div>
        <div class="text-xs text-right">{{$riddle->published_at}}</div>
        @endcan

        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="grid grid-cols-3 items-center">

                {{-- Левая часть (пусто или логотип) --}}
                <div></div>

                {{-- Кнопка редактировать --}}
                @can('update', $riddle)
                    <div class="flex justify-center gap-6 text-base">
                        <a href="{{ route('riddles.edit', $riddle) }}"
                            class="inline-flex items-center px-4 py-2 whitespace-nowrap text-gray-700 font-medium rounded-lg shadow-md hover:text-accent transition">
                            Редактировать
                        </a>
                    </div>
                @endcan

            </div>
        </div>
    </div>
    <x-slot:sidebar>
        @include('sidebars.basic')
    </x-slot:sidebar>
</x-app-layout>