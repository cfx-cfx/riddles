{{-- Форма поиска --}}
<div class="p-4 my-4 sm:mt-12 bg-white rounded-md">
    @if($riddles->isNotEmpty())
        <h2 class="text-accent-500 font-medium">Ваши данетки</h2>   
        @foreach($riddles as $riddle)
            <a href="{{route('riddles.show', ['riddle' => $riddle])}}" class="inline-block py-2 text-gray-600 hover:underline underline-offset-4 decoration-gray-200">{{$riddle->title}}</a>
        @endforeach
    @else
        <div class="text-accent-700 font-semibold">Здесь будут ссылки на добавленные вами данетки</div>
    @endif
</div>

{{-- Кнопка Добавить данетку --}}
<div class="p-4 my-4 bg-white rounded-md text-gray-600">
    Если вы знаете данетки, которых здесь нет, пожалуйста, добавьте их на сайт.
    <a href="{{route('riddles.create')}}"" class=" block my-6 px-6 py-2 rounded-lg border border-accent-600
        bg-accent-500 text-white font-semibold opacity-90 hover:opacity-100 text-center">
        Добавить данетку
    </a>
</div>

{{-- Написать администратору --}}
<div class="mb-6 p-4 bg-white rounded-md text-gray-600">
    <h4 class="mb-4 font-medium text-accent-500">Написать администратору</h4>
    <form method="POST" action="/inquiries/send">
        @csrf
        @honeypot
        <input name="subject" placeholdеr="Тема" class="block mb-4 rounded-md border border-gray-400" required>
        <textarea name= "message" rows="5" class=" block mb-4 rounded-md border border-gray-400" required></textarea>
        <button type="submit" class="block w-full px-4 py-1 rounded-lg border border-accent-600
            bg-accent-500 text-white font-semibold opacity-90 hover:opacity-100">
                Отправить
        </button>
    </form>

    <a href="/inquiry/show" class="block py-4 cursor-pointer hover:underline underline-offset-4 decoration-gray-300">Обращения и ответы</a>

</div>



