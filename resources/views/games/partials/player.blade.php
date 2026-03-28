<!-- Ввод -->
<form id="chat-form" method="POST" action="/message/sent" class="border-t p-1 pb-2 grid grid-cols-[1fr_auto] gap-2 items-start content-start">
    @csrf
    <div id="replyPreviewContainer" class="col-span-2"></div>
    <div id="chat-input-wrapper" class="border rounded-md overflow-hidden focus-within:border-accent-500"> 
    
        <!-- сюда будет вставляться replyPreview -->
        <div class="flex items-center">
            <input id="message-input" name="content" type="text" placeholder="Ваш вопрос или сообщение"
                class="w-full px-3 py-2 text-sm outline-none border-0 focus:ring-0" autocomplete="off"/>
        </div>

    </div>

    <button type="submit" class="px-4 py-2 bg-accent-500 text-white rounded hover:bg-accent-500 self-end h-auto"> → </button>
    <input type="hidden" name="parent_id" id="parent_id">

</form>

