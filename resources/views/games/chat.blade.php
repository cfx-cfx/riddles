<x-app-layout>
    <x-slot name="title">
        Игра. Обсуждение игры.
    </x-slot>

    <x-slot name="header">
        <div class="flex justify-between items-center w-full">

            @if($game)
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Идет игра. Ведущий - {{$game->hostUser->name}}
                </h2>
            @else
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Обсуждение игры
                </h2>

                @include('games.partials.small_timer')
            @endif

        </div>
    </x-slot>  

     
    <div class="flex flex-col h-full max-h-[80vh] border rounded bg-white">
        <!-- Заголовок и данетка-->
    <div class="px-4 py-3 border-b">

    @if($game)

        <div class="font-semibold mb-1">
            Разгадываем данетку:
        </div>

        <div class="text-accent-600 font-semibold">
            {{$riddle->riddle}}
        </div>

    @else
        <table class="text-sm">
            <tr>
                <td class="px-3 py-2 font-semibold align-top">Данетка</td>
                <td class="px-3 py-2 text-accent-600 font-semibold">{{$riddle->riddle}}</td>
            </tr>
            <tr>
                <td class="px-3 py-2 font-semibold align-top">Ответ</td>
                <td class="px-3 py-2 text-red-600 font-semibold">{{$riddle->solution_text}}</td>
            </tr>
        </table>

    @endif

</div>

    <!-- Сообщения -->
    <div id="chat-messages" data-game-id="{{ $game?->id??$latestFinished->id }}" 
        data-is-host="{{ auth()->id() === $game?->host_user_id }}"
        class="relative flex-1 overflow-y-auto p-4 space-y-2 text-sm">

        @foreach ($messages as $message)

            {{-- Системное сообщение --}}
            @if ($message->type === 'system')
            <div class="system flex justify-center">
                <div  class="my-3 bg-brand-50 text-gray-600 font-semibold px-4 py-2 rounded-lg shadow-lg max-w-[60%] text-center">
                    {{ $message->content }}
                </div>
            </div>

            {{-- Вопрос игрока --}}
            @else
                <div class="my-3 ">
                    <div data-id="{{ $message->id }}" class="message inline-block group cursor-pointer relative max-w-[80%] bg-gray-100 px-4 py-1 rounded-lg shadow-sm">
                        <span class="author block text-xs font-semibold text-accent-700">
                            {{ $message->user->name }}
                        </span>
                        <span class="content block">
                            {{ $message->content }}
                        </span>
                        @if(!$game)
                            <button class="reply-btn absolute z-10 -bottom-3 right-[-65px]  border border-gray-100 bg-white shadow-xl px-3 py-1 rounded-md text-sm
                                        opacity-0 group-hover:opacity-100 transition">Ответить</button> 
                        @endif                 
                    </div>
           
                    @if($game && $game->isHost() && (!$message->parent_id) && $message->replies->isEmpty()) 
                        <div class="yes-no-actions mt-2 flex gap-2">                   
                            @include('games.partials.yes_no_buttons')
                        </div>
                    @endif

                    {{-- Ответы --}}
                    @foreach($message->replies as $reply)
                        <div class="replies my-3">
                            @if($reply->type === 'host')
                                <div class="host inline-block ml-8 bg-cyan-50 font-medium text-blue-800 px-4 py-2 rounded-lg shadow-lg">
                                    {{ $reply->content }}
                                </div>
                            @else
                                <div class="ml-8 bg-gray-100 rounded-md px-4 py-1 mt-2 inline-block max-w-md">
                                    <span class="author block text-xs font-semibold text-accent-700">
                                        {{ $reply->user->name }}
                                    </span>
                                    <span class="block content text-sm">
                                        {{ $reply->content }}
                                    </span>
                                </div>
                            @endif
                        </div>                
                    @endforeach                    
                </div>
            @endif
        @endforeach            
    </div>
  
    {{-- Панель ведущего (скрыта сначала) или игроков--}}
    @php $user=auth()->user()  @endphp 

    @if ($scheduledGame && $scheduledGame->isHost($user))
        
        <div id="host-panel" class="hidden">
            @include('games.partials.host')
        </div>

        {{-- Панель игрока (видна сначала) --}}
        <div id="player-panel">
             @include('games.partials.player')
        </div>
    {{-- $game - активная игра --}}    
    @elseif($game && $game->isHost($user))
        <div id="host-panel">
            @include('games.partials.host')
        </div>

    @else
        @include('games.partials.player')
    @endif

    </div>
</x-app-layout>