<x-app-layout>
    <x-slot name="title">
        Данетки - riddles. Создать новую игру.
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Новая игра
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('games.store') }}" class="mt-8 pb-8 space-y-6 w-full">
        @csrf
        <div class="mx-4">
            <label class=" block text-sm font-medium text-gray-700 mb-1">
                Начало игры
            </label>
            <input type="datetime-local" name="starts_at" class="px-4 w-full rounded-sm border-gray-300"
                placeholder="Начало игры" required>
        </div>
        @error('starts_at')
        <div class="mx-4 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        <div class="mx-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                <select name="status" class="w-full rounded-sm border-gray-300">
                    @foreach(\App\Enums\GameStatus::cases() as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('status')
            <div class="mx-2 mt-1 text-sm font-medium !text-red-500">{{ $message }}</div>
        @enderror

        <div class="mx-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Ведущий   
            </label>
            <input name="host_name" type="text" class="w-full rounded-sm border-gray-300 placeholder-gray-800"
                placeholder="Имя ведущего"/>
        </div>
        @error('host_name')
            <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        <div class="mx-2 flex justify-center gap-8 pt-4 border-t">
           <button type="submit" class="px-4 py-1 rounded-lg border border-accent-600
            bg-accent-500 text-white font-semibold opacity-90
            hover:opacity-100">
                Сохранить
              </button>
            <button type="reset"
            class="inline-flex items-center px-4 py-1 whitespace-nowrap text-gray-700 font-medium rounded-lg shadow-md hover:text-accent-500 transition">
             Отмена
            </button>
        </div>
    </form>
</x-app-layout>

