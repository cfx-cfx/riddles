<x-app-layout>
    <x-slot name="title">
        Добро пожаловать в мир данеток
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Расписание игр
        </h2>
    </x-slot> 

    <div class="mt-4 p-4 space-y-6 w-full bg-white rounded-md">
        <h2 class="font-medium text-accent-500">Ближайшие игры</h2>
        <div>
            {!! $scheduledDates->take(3)
                ->map(fn($d) => $d->format('d.m H:i'))
                ->implode(', &nbsp; ') !!} 
        </div>
    </div>

    <div class="mt-4 p-4 space-y-6 w-full bg-white rounded-md">
        <h2 class="font-medium text-accent-500">Остальные игры</h2>
        <div>
            {!! $scheduledDates->take(-3)
                ->map(fn($d) => $d->format('d.m H:i'))
                ->implode(', &nbsp; ') !!} 
        </div>
    </div>

    @if($userIsHostDates->isNotEmpty())
    <div class="mt-4 p-4 space-y-6 w-full bg-white rounded-md">
        <h2 class="font-medium text-accent-500">Вы - ведущий</h2>
        <div>
            @foreach($userIsHostDates as $d)
                <span class="{{ $d->isCurrentWeek() ? 'text-green-600 font-bold' : '' }}">
                    {{ $d->format('d.m H:i') }}
                </span>@if(!$loop->last)&nbsp;&nbsp;@endif
            @endforeach
        </div>
    </div>
    @endif
</x-app-layout>

