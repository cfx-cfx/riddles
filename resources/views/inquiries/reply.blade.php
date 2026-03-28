<x-app-layout>
    <x-slot name="title">
        Добро пожаловать в мир данеток
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Ответ на обращение
        </h2>
    </x-slot>
<div class="px-4 pt-8   ">
    <h4 class="text-sm font-medium text-accent-600 mb-1">Обращение</h4>
    <div class="bg-white rounded-md w-full p-4">
        <div>
            <span class="font-semibold">Тема:</span>
            <span class="p-2">{{$inquiry->subject}}</span>
        </div>
        <div>{{ $inquiry->message }}</div>
    </div>

    <form method="POST" action="{{ route('reply.store',['inquiry'=>$inquiry]) }}" class="mt-8 pb-8 space-y-6 w-full">
        @csrf
        @method('put')
        <div>
            <label class="block text-sm font-medium text-accent-600 mb-1">
                Условие
            </label>
            <textarea name="admin_reply" rows="4" class="w-full rounded-lg border-gray-300"
                    placeholder="Ответ на обращение" required></textarea>
        </div>

        @error('admin_reply')
            <div class="mx-2 mt-1 text-sm font-semibold !text-red-500">{{ $message }}</div>
        @enderror

        <!-- Actions -->
        <div class="mx-2 flex justify-center gap-8 pt-4 border-t">
            <button type="reset"
                class="inline-flex items-center px-4 py-2 whitespace-nowrap text-gray-700 font-medium rounded-lg shadow-md hover:text-accent transition">
                Отмена
            </button>

            <button type="submit" class="px-4 py-1 rounded-lg border border-accent-600
                    bg-accent-500 text-white font-semibold opacity-90  hover:opacity-100">
                Сохранить
            </button>

        </div>

    </form>
</div>
</x-app-layout>

