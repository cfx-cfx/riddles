<x-app-layout>
    <x-slot name="title">
        Данетки - riddles. Создать новую данетку.
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Добавить новую данетку
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('riddles.store') }}" class="mt-8 pb-8 space-y-6 w-full">
        @csrf
        @honeypot
        <div class="mx-4">
            <label class=" block text-sm font-medium text-gray-700 mb-1">
                Название
            </label>
            <input type="text" name="title" class="px-4 w-full rounded-lg border-gray-300"
                placeholder="Короткое название данетки" required>
        </div>
        @error('title')
        <div class="mx-4 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror


        <div class="mx-4">
            <label class=" block text-sm font-medium text-gray-700 mb-1">
                Условие
            </label>
            <textarea name="riddle" rows="4" class="w-full rounded-lg border-gray-300"
                placeholder="Опиши странную ситуацию..." required></textarea>
        </div>
        @error('riddle')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        <div class="mx-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Разгадка
            </label>
            <textarea name="solution_text" rows="5" class="w-full rounded-lg border-gray-300"
                placeholder="Полное объяснение происходящего" required></textarea>
        </div>
        @error('solution_text')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        @can('changeStatus', App\Models\Riddle::class)
        <div class="mx-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                <select name="status" class="w-full rounded-lg border-gray-300">
                    @foreach(\App\Enums\RiddleStatus::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('status')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror
        @endcan

        @can('adminOnly', App\Models\Riddle::class)
        <!-- status -->
        <div class="mx-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Статус
                </label>
                <select name="status" class="w-full rounded-lg border-gray-300">
                    @foreach(\App\Enums\RiddleStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(old('status')===$status->value) >{{ $status->label() }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('status')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        <!-- searchable -->
        <div class="mx-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Слова для поиска
            </label>
            <textarea name="searchable" rows="5" class="w-full rounded-lg border-gray-300"
                placeholder="Ищем по ..."></textarea>
        </div>
        @error('searchable')
        <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror
        @endcan

        <!-- Actions -->
        <div class="mx-2 flex justify-center gap-8 pt-4 border-t">
            <button type="reset"
                class="inline-flex items-center px-4 py-2 whitespace-nowrap text-gray-700 font-medium rounded-lg shadow-md hover:text-accent transition">
                Отмена
            </button>

            <button type="submit" class="px-4 py-1 rounded-lg border border-accent-600
            bg-accent-500 text-white font-semibold
            hover:opacity-90">
                Сохранить
            </button>

        </div>

    </form>

    {{-- Сайдбар --}}
    <x-slot:sidebar>
        @include('sidebars.basic')
    </x-slot:sidebar>
</x-app-layout>