    <div class="flex items-center gap-3 text-white ml-auto">

        <span class="text-sm opacity-80">
            До игры
        </span>
   
        <div id="game-timer"
            data-starts-at="{{ $scheduledGame->starts_at->toIso8601String() }}"
             class="flex items-center gap-2 font-mono text-accent-300">

            <span data-hours>00</span>
            <span class="opacity-50">:</span>

            <span data-minutes>00</span>
            <span class="opacity-50">:</span>

            <span data-seconds>00</span>
        </div>
    </div>

