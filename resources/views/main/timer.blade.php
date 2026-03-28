    <div class="mt-8 bg-white rounded-sm shadow-sm border border-gray-200 px-6 py-4 w-full flex flex-col items-center gap-2">
        <span class="text-sm text-gray-500">
            До игры осталось
        </span>

        <div id="main-game-timer" data-starts-at="{{ $time->toIso8601String() }}"
            class="flex items-center gap-4 text-center">
            <div>
                <div class="text-2xl font-semibold text-accent-500" data-days>00</div>
                <div class="text-xs text-gray-500">дни</div>
            </div>

            <div class="text-gray-400 text-xl -mt-4 select-none">:</div>

            <div>
                <div class="text-2xl font-semibold text-accent-500" data-hours>00</div>
                <div class="text-xs text-gray-500">часы</div>
            </div>

            <div class="text-gray-400 text-xl -mt-4 select-none">:</div>

            <div>
                <div class="text-2xl font-semibold text-accent-500" data-minutes>00</div>
                <div class="text-xs text-gray-500">минуты</div>
            </div>
        </div>
    </div>
