<x-app-layout>
    <x-slot name="title">
        {{ __('Данетки')}}. {{ __('Редактирование данетки')}}.
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Редактировать данетку
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('riddles.update',['riddle'=>$riddle]) }}" class="mt-8 pb-8 space-y-6 w-full">
        @method('PUT')
        @csrf
        @honeypot
        <div class="mx-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Название
            </label>
            <input type="text" name="title"
                class="px-4 w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                value="{{$riddle->title }}" required>
        </div>
        @error('title')
        <div class="mx-4 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        <div class="mx-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Условие
            </label>
            <textarea name="riddle" rows="4"
                class="w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent" required>{{$riddle->riddle}}
            </textarea>
        </div>
        @error('riddle')
        <div class="mx-4 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        <div class="mx-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Разгадка
            </label>
            <textarea name="solution_text" rows="5"
                class="w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent" required>{{$riddle->solution_text}}
                </textarea>
        </div>

        @error('solution_text')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        @can('adminOnly', App\Models\Riddle::class)
        <div class="mx-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Статус
                </label>
                <select name="status" class="w-full rounded-lg border-gray-300">
                    @foreach(\App\Enums\RiddleStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected($status==$riddle->status) >{{ $status->label() }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('status')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        <div class="mx-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Слова для поиска
            </label>
            <textarea name="searchable" rows="5"
                class="w-full rounded-lg border-gray-300 focus:border-accent focus:ring-accent"
                placeholder="Ищем по ..." value="{{old('searchable') }}">{{$riddle->searchable}}</textarea>
        </div>
        @error('searchable')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror
        
        <div class="mx-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Игра
                </label>
                <select name="game_id" class="w-full rounded-lg border-gray-300">
                    <option value="" @selected(old('game_id', $riddle->game_id) == null)>Без игры </option>
                    @foreach($games as $game)
                    <option value="{{$game->id}}" @selected(old('game_id', $riddle->game_id) == $game->id)>Игра {{$game->id}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('game_id')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        @endcan
        <!-- Actions -->
        <div class="mx-2 flex justify-center gap-8 py-2 border-t">
            <button type="reset"
                class="inline-flex items-center px-4 py-1 whitespace-nowrap text-gray-700 font-medium rounded-lg shadow-md hover:text-accent transition">
                Отмена
            </button>

            <button type="submit" class="px-6 py-1 rounded-lg border border-accent-500 opacity-80
           bg-accent-500 text-white font-semibold
           hover:opacity-100">
                Сохранить
            </button>

        </div>

    </form>

    {{-- Сайдбар --}}
    <x-slot:sidebar>
        @include('sidebars.basic')
    </x-slot:sidebar>

</x-app-layout>