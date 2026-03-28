        <form method="POST" action="/message/sent" class="yes_no_buttons flex flex-wrap items-center gap-2 my-3">
            @csrf
            @honeypot

            <input type="hidden" name="parent_id" value="{{$message->id}}">
            <button type="submit" name="content" value="Да" class="px-5 py-1 rounded-lg bg-cyan-50 text-gray-800 font-semibold hover:bg-cyan-100 shadow-lg">
                Да
            </button>
            <button type="submit" name="content" value="Нет" class="px-5 py-1 rounded-lg bg-cyan-50 text-gray-800 font-semibold hover:bg-cyan-100 shadow-lg">
                Нет
            </button>
            <button type="submit" name="content" value="Не важно" class="px-5 py-1 rounded-lg bg-cyan-50 text-gray-800 font-semibold hover:bg-cyan-100 shadow-lg">
                Не важно
            </button>
            <button type="submit" name="content" value="Некорректный вопрос" class="px-5 py-1 rounded-lg bg-cyan-50 text-gray-800 font-semibold hover:bg-cyan-100 shadow-lg">
                Некорректный вопрос
            </button>
        </form>
