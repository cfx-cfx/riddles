<x-app-layout>
    <x-slot name="title">
        Результаты поиска данеток
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Результаты поиска по запросу "{{$request->q}}"
        </h2>
    </x-slot>

    <div class="mt-8 p-4 space-y-6   mx-auto w-full bg-white rounded-sm">
        @if($riddles->count())
        <ol class="list-decimal pl-8">
            @foreach($riddles as $riddle)

            <li class=" py-4">
                <h4 class=" font-medium text-accent-500 pb-2">{{$riddle->title}}</h4>
                <div class="pb-4">
                    {{$riddle->riddle}}
                </div>
                @if(auth()->user() && (auth()->user()?->hasRole('admin') or auth()->user()->hasRole('author')) )
                <div class=" px-4 text-accent-600">{{$riddle->solution_text}}
                </div>
                @endif
            </li>

            @endforeach
        </ol>

        @else
        По вашему запросу ничего не найдено
        @endif
    </div>

    <x-slot:sidebar>
        @include('sidebars.basic')
    </x-slot:sidebar>
</x-app-layout>