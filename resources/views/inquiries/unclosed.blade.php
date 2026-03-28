<x-app-layout>
    <x-slot name="title">
        Добро пожаловать в мир данеток
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Обращения и ответы на них
        </h2>
    </x-slot>

    <div class="px-4 pt-8">
        @if(!$inquiries->isEmpty())
            <div class="bg-white rounded-md w-full my-4 p-4 text-green-600 font-medium">Обращение считается закрытым, если в течение 3 дней после ответа администратора нет повторных обращений с этой же темой</div>
            @foreach($inquiries as $inquiry)
                <div class="bg-white rounded-md w-full my-4 p-4">
                    <h4 class="text-sm font-medium text-accent-600 mb-1">Ваше обращение</h4>
                    <div>
                        <span class="font-semibold">Тема:</span>
                        <span class="p-2">{{$inquiry->subject}}</span>
                    </div>
                    <div>{{ $inquiry->message }}</div>
                    @if($inquiry->admin_reply)
                        <div class="pl-6 py-4">
                            <div class="text-sm font-medium text-accent-600 mb-1">Ответ на обращение</div>
                            <div class="bg-white rounded-md w-full">{{$inquiry->admin_reply}}</div>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="bg-white rounded-md w-full p-4">У вас нет незакрытых обращений</div>
        @endif
    </div>
</x-app-layout>
