<div class="space-y-3 sm:space-y-6">
    {{-- Стать ведущим --}}
    @if( $canBeHost)
    <div class="p-4 sm:px-8 md:py-6 md:mb-6 bg-white rounded-md text-gray-600">
        Не хотите ли быть ведущим игры? 
        <x-sidebar-reference href="{{'games/date/picker'}}">
            Да, хочу
        </x-sidebar-reference>
    </div> 
    @endif

    {{-- Кнопка Добавить данетку --}}
    <div class=" p-4 sm:px-8 md:px-4 md:py-6 md:mb-6  bg-white rounded-md text-gray-600">
        Если вы знаете данетки, которых здесь нет, пожалуйста, добавьте их на сайт.
        <x-sidebar-reference href="{{route('riddles.create')}}">
            Добавить
        </x-sidebar-reference>
    </div>

    {{-- Написать администратору --}}
    <div class=" p-4 sm:px-8 md:px-4 md:py-6 md:mb-6  bg-white rounded-md text-gray-600">
        <h4 class="mb-4 font-medium text-accent-500 text-center">Написать администратору</h4>
        <form method="POST" action="/inquiries/send">
            @csrf
            @honeypot
            <input name="subject" placeholdеr="Тема" class="w-full block mb-4 rounded-md border border-gray-300" required>
            <textarea name= "message" rows="5" class="w-full block mb-4 rounded-md border border-gray-300" required></textarea>
            <x-sidebar-button>
                Отправить
            </x-sidebar-button>        
        </form>

        <a href="/inquiry/show" class="block text-center font-medium text-accent-500 py-4 cursor-pointer hover:underline underline-offset-4 decoration-gray-300">Обращения и ответы</a>
    </div>

    {{-- Данетки пользователя --}}
    <div class="p-4 sm:px-8 md:py-6 md:mb-6  bg-white rounded-md">
        @if($riddles->isNotEmpty())
            <h2 class="text-accent-500 font-medium text-center">Ваши данетки</h2>   
            @foreach($riddles as $riddle)
                <div>
                    <a href="{{route('riddles.show', ['riddle' => $riddle])}}" class="inline-block py-1 text-gray-600 hover:underline underline-offset-4 decoration-gray-200">{{$riddle->title}}</a>
                </div>
            @endforeach
        @else
            <div class="text-accent-700 font-semibold">Здесь будут ссылки на добавленные вами данетки</div>
        @endif
    </div>    
</div>



