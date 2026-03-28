<x-app-layout>
    <x-slot name="title">
        Данетки - riddles. Правила.
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-accent-500">
            Правила игры
        </h2>
    </x-slot>
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-3">
        <h3 class="text-lg font-semibold text-slate-900">
            Загадка про лифт
        </h3>

        <p class="text-slate-600 leading-relaxed">
            Человек заходит в лифт, поднимается на 7 этаж,
            а выходит на 5. Почему?
        </p>

        <div class="flex items-center justify-between text-sm">
            <span class="text-slate-500">Категория: логика</span>

            <a href="#" class="text-accent-500 font-semibold font-medium hover:underline">
                Читать →
            </a>
        </div>
        <div class="flex gap-3">
            <button class="inline-flex items-center px-5 py-2.5
               bg-accent-500 text-white font-medium
               rounded-lg shadow-sm
               hover:bg-accent-500/90
               focus:outline-none focus:ring-2 focus:ring-accent/30
               transition">
                Сохранить
            </button>

            <button class="inline-flex items-center px-5 py-2.5
               bg-slate-100 text-slate-700 font-medium
               rounded-lg
               hover:bg-slate-200
               transition">
                Отмена
            </button>
        </div>
        <span class="inline-flex items-center px-2.5 py-1
           rounded-full text-xs font-medium
           bg-accent/10 text-accent">
            Опубликовано
        </span>
        <span class="bg-green-100 text-green-700">Активно</span>
        <span class="bg-amber-100 text-amber-700">Черновик</span>
        <span class="bg-red-100 text-red-700">Ошибка</span>
    </div>

</x-app-layout>