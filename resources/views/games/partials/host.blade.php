
<div class="border-t border-gray-300">
{{-- Кнопка "Начать игру" --}}
@if (! $game )
    <div class="flex justify-center mb-4">
        <form method="POST" action="{{ route('games.start', $scheduledGame) }}">
            @csrf
            <button class="mt-4 px-6 py-1 rounded-lg bg-accent-500 opacity-90 text-white font-semibold hover:opacity-100">
                Начать игру
            </button>
        </form>
    </div>
@endif

    @if($game)      {{-- Завершение игры и ответ --}}

    <div class=" pt-1 flex justify-center gap-4 mb-4">

        <form method="POST" action="{{ route('games.end', $game) }}">
            @csrf
            <button class="px-4 py-1 rounded-md bg-accent-500 opacity-90 text-white text-sm font-semibold hover:opacity-100"">
                Завершить игру
            </button>
        </form>

    </div>
    @endif

</div>