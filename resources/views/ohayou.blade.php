<x-app-layout>
    <x-slot name="title">
        Добро пожаловать в мир данеток
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Админка
        </h2>
    </x-slot> 
<div class="max-w-6xl mx-auto mt-8 px-4">
    <h2 class="text-xl font-bold mb-6 text-accent-600 text-center">
        Запланированные и активные игры
    </h2>

    <div class="bg-white shadow-lg rounded-sm overflow-hidden">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                        ID
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                        Начало
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                        Статус
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                        ID ведущего
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">
                        Данетка
                    </th>

                    <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase">
                   
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($games as $game)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                            {{ $game->id }}
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                            {{ $game->starts_at }}
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="px-3 py-1 text-sm border font-semibold rounded-sm
                                @if($game->status->value === 'active')
                                    bg-brand-50 text-brown-600
                                @elseif($game->status->value === 'scheduled')
                                    bg-cyan-50 text-blue-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif
                            ">
                                {{ $game->status }}
                            </span>
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                            {{ $game->host_user_id }}
                        </td>
                        
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                            {{ $game->riddle?->id}}
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('games.edit', ['game'=>$game]) }}"
                               class="inline-flex items-center px-4 py-1 bg-gray-500 opacity-90 text-white text-sm font-semibold rounded shadow hover:opacity-100">
                                Изменить
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                            Нет запланированных или активных игр
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="max-w-6xl mx-auto mt-8 px-4 font-semibold text-center text-red-600">{{session('message') }}</div>

<div class="mt-8 pb-8 flex justify-center w-full gap-6">
    <a href="{{ route('games.create') }}"
       class="inline-block px-4 py-1 rounded-lg border border-accent-600 opacity-90
              bg-accent-500 text-white font-semibold
              hover:opacity-100 text-center">
        Новая игра
    </a>
    <a href="{{ route('riddles.index') }}"
       class="inline-block px-4 py-1 rounded-lg border border-accent-600 opacity-90
              bg-accent-500 text-white font-semibold
              hover:opacity-100 text-center">
        Выбрать данетку
    </a>
    <form method="GET" action="/games/generate">
        <input type="submit"  value="Создать игры" class="inline-block px-4 py-1 rounded-lg border border-accent-600 opacity-90
              bg-accent-500 text-white font-semibold
              hover:opacity-100 text-center">        
    </form>    
</div>

<div class="max-w-6xl mx-auto mt-8 px-4">
    <h2 class="text-xl font-bold mb-6 text-accent-600 text-center">
        Обращения к админу
    </h2>
    <div class="bg-white shadow-lg rounded-sm overflow-hidden">            
        @if(!$inquiries->isEmpty())
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>                                        
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Тема</th>       
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Статус</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Ответ</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase"></th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase"></th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $inquiry->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $inquiry->subject }}</td>                           
                            <td class="px-4 py-2 nowrap">
                                <span class="px-3 py-1 text-sm border font-semibold rounded-sm
                                    @if($inquiry->status->value === 'new')
                                        bg-brand-50 text-brown-600
                                    @else
                                        bg-cyan-50 text-blue-800
                                    @endif
                                ">{{ $inquiry->status }}</span>
                            </td>    
                            <td class="px-4 py-2 text-sm text-gray-900">
                                {{ Illuminate\Support\Str::limit($inquiry->admin_reply, 20, '...') }}
                            </td>                        
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $inquiry->user_id}}</td>
                            <td class="px-4 py-2 text-right text-sm font-medium">
                                <a href="{{ route('inquiry.reply', ['inquiry'=>$inquiry]) }}"
                                    class="inline-flex items-center px-4 py-1 bg-gray-500 opacity-90 text-white text-sm font-semibold rounded shadow hover:opacity-100">
                                    Ответить
                                </a>
                            </td>
                        </tr>                
                    @endforeach
                </tbody>
            </table>                
        @else
            <div  class="px-6 py-6 text-center text-gray-500">
                Нет незакрытых сообщений
            </div>
        @endif
        
    </div>
</div>

</x-app-layout>