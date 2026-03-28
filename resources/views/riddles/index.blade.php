<x-app-layout>
    <x-slot name="title">
        Данетки - riddles. Все данетки.
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Данетки
        </h2>
    </x-slot>
    <div class="mt-8 p-4 space-y-6   mx-auto w-full bg-white rounded-sm">

        <ol start="{{ $riddles->firstItem() }}" class="list-decimal pl-8">
            @foreach($riddles as $riddle)
            <li class=" py-2">
                <div class="font-medium text-accent-500">
                    <a class="hover:underline underline-offset-4 decoration-accent-300"
                        href="{{route('riddles.show',['riddle'=>$riddle]); }}">
                        {{$riddle->title}}
                    </a>
                </div>
                <div class="pb-2">
                    <a class="text-gray-700 hover:underline underline-offset-4 decoration-gray-200"
                        href="{{route('riddles.show',['riddle'=>$riddle]); }}">
                        {{$riddle->riddle}}
                    </a>
                </div>

                @can('adminOrAuthor', $riddle)
                <div class=" px-4 text-accent-600">{{$riddle->solution_text}} </div>
                @endcan

                @can('adminOnly', $riddle)
                <div class="mt-4 flex justify-center items-center gap-4 w-full">
                    <span>game_id={{$riddle->game_id}}</span>
                    <a href="{{ route('riddles.edit', ['riddle'=>$riddle]) }}"
                        class="px-3 py-1 text-sm border border-cyan-300 font-semibold rounded-md bg-cyan-50 text-blue-800
                                hover:bg-cyan-100 text-center">
                        Редактировать
                    </a>
                </div>
                @endcan    
                
            </li>

            @endforeach
        </ol>

    </div>

    <div class="mt-8 pb-8 space-y-6   mx-auto w-full  sm:w-[80%]  max-w-[1000px]">
        {{ $riddles->links() }}
    </div>
    <x-slot:sidebar>
        @include('sidebars.basic')
    </x-slot:sidebar>
</x-app-layout>