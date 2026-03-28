<div class="inline-block message cursor-pointer relative max-w-[80%] bg-gray-100 px-4 py-1 rounded-lg shadow-sm"
    <span class="author block text-xs font-semibold text-accent-700">
        {{ $message->user->name }}
    </span>
    <span class="content block">
        {{ $message->content }}
    </span>
    <button class="reply-btn absolute z-10  -bottom-5 -right-18 border border-gray-100 bg-white shadow-xl px-3 py-1 rounded-md text-sm" style="display:none;">Ответить</button>                  
</div>
