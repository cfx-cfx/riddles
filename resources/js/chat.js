export function initChat() {
    initTimer(); // таямер справа
    initReply();  // ответ на сообщени
    initScroll();  // прокрутка вниз
    initMessage(); // отмена отправки сообщения через HTTP и отправвка ее через axios
    initEcho();  // широковещание 
    initYesNoButtons(); // обработчик кнопок ведущего
}

function initTimer() {
    const timer = document.getElementById('game-timer');
    if (!timer) return;

    const startsAt = timer.dataset.startsAt;
    if (!startsAt) return;

    const startTime = new Date(startsAt).getTime();
    if (isNaN(startTime)) return;

    const hoursEl = timer.querySelector('[data-hours]');
    const minutesEl = timer.querySelector('[data-minutes]');
    const secondsEl = timer.querySelector('[data-seconds]');

    function updateDisplay(h, m, s) {
        if (hoursEl) hoursEl.textContent = String(h).padStart(2, '0');
        if (minutesEl) minutesEl.textContent = String(m).padStart(2, '0');
        if (secondsEl) secondsEl.textContent = String(s).padStart(2, '0');
    }

    // отображение панели ведущего
    let hostLoaded = false;

    const hostPanel = document.getElementById('host-panel');
    const playerPanel = document.getElementById('player-panel');

    function switchToHost() {
        if (hostPanel) hostPanel.classList.remove('hidden');
        if (playerPanel) playerPanel.classList.add('hidden');
    }

    function updateTimer() {
        let diff = Math.floor((startTime - Date.now()) / 1000);

        if (diff <= 0) {
            updateDisplay(0, 0, 0);
            switchToHost();
            return;
        }

        if (diff <= 600) switchToHost();

        const h = Math.floor(diff / 3600);
        diff %= 3600;
        const m = Math.floor(diff / 60);
        const s = diff % 60;

        updateDisplay(h, m, s);
    }

    updateTimer();
    setInterval(updateTimer, 1000);
}

// создается блок "Ответить" над формой ввода и добавляет значение parent_id в ответ
function initReply() {
    document.addEventListener('click', function (e) {

        const replyBtn = e.target.closest('.reply-btn');
        const cancelBtn = e.target.closest('.cancel-reply');

        if (cancelBtn) {
            clearReply();
            return;
        }

        if (replyBtn) {
            const message = replyBtn.closest('.message');
            if (!message) return;

            const messageId = message.dataset.id;
            const author = message.querySelector('.author')?.textContent ?? '';
            const content = message.querySelector('.content')?.textContent ?? '';

            const parentId = document.getElementById('parent_id');
            if (parentId) parentId.value = messageId;

            let replyPreview = document.getElementById('replyPreview');

            if (!replyPreview) {
                replyPreview = document.createElement('div');
                replyPreview.id = 'replyPreview';
                replyPreview.className = 'px-2 rounded-md mb-2 relative';

                replyPreview.innerHTML = `
                    <div class="flex justify-between items-start gap-3">
                        <div>
                            <div class="author text-xs font-semibold text-accent-700"></div>
                            <div class="content text-sm"></div>
                        </div>
                        <button type="button" class="cancel-reply text-gray-400 hover:text-red-500 text-sm">✕</button>
                    </div>
                `;

                document.getElementById('replyPreviewContainer')?.append(replyPreview);
            }

            replyPreview.querySelector('.author').textContent = 'Ответить ' + author;
            replyPreview.querySelector('.content').textContent = content;

            document.getElementById('message-input')?.focus();
        }
    });
}

// вызывается из initReply, очистка блока ответа над message-input 
function clearReply() {
    document.getElementById('replyPreview')?.remove();
    const parentId = document.getElementById('parent_id');
    if (parentId) parentId.value = '';
}

function initScroll() {
    const chat = document.getElementById('chat-messages');
    if (!chat) return;

    function scrollToBottom() {
        chat.scrollTo({
            top: chat.scrollHeight,
            behavior: "smooth"
        });
    }

    function isNearBottom() {
        const d = chat.scrollHeight - chat.scrollTop - chat.clientHeight;
        return d < 120;
    }

    const observer = new MutationObserver(() => {
        if (isNearBottom()) scrollToBottom();
    });

    observer.observe(chat, { 
        childList: true,
        subtree: true // учитывать дочернии блоки - ответвы на сообщения
    });

    scrollToBottom();
}

function initMessage() {
    const form = document.querySelector('#chat-form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const data = new FormData(form);

        axios.post('/message/sent', data)
            .catch(err => console.error(err));

        form.reset();
        clearReply();
    });
}

function initEcho() {
    if (!window.location.pathname.startsWith('/chat')) return;
    
    const chat = document.getElementById('chat-messages');
    if (!chat) return;

    const gameId = chat.dataset.gameId;

    if (!window.Echo || !gameId) return;

    console.log(`game.${gameId}`);

    Echo.join(`game.${gameId}`)
        .listen('.message.sent', (e) => {
            appendMessage(e);
        });

    Echo.join(`game`)        
        .listen('GameStarted', (e) => {
            window.location.href = window.location.href;
        })                
        .here(users => {
            console.log('Users:', users);
        })
        .listen('GameEnded', (e) => {
            window.location.href = window.location.href;
        });
}

// добавляет сообщения в DOM, вызывается из Echo
function appendMessage(message) {
    const hasNoReplies = message.hasNoReplies ?? true;
    const chat = document.querySelector('#chat-messages');
    const stage = message.stage ?? 'game';
    const isHost = Number(chat.dataset.isHost);

    // --- SYSTEM MESSAGE ---
    if (message.type === 'system') {
        const systemWrapper = document.createElement('div');
        systemWrapper.className = 'system flex justify-center';

        const systemInner = document.createElement('div');
        systemInner.className = 'my-3 bg-brand-50 text-gray-600 font-semibold px-4 py-2 rounded-lg shadow-lg max-w-[60%] text-center';
        systemInner.textContent = message.content;

        systemWrapper.appendChild(systemInner);
        chat.appendChild(systemWrapper);
        return;
    }

    // --- USER MESSAGE ---   
    const wrapper = document.createElement('div');
    wrapper.className = 'my-3';
    if(message.parent_id===null) {
        const messageDiv = document.createElement('div');
        messageDiv.setAttribute('data-id', message.id);
        messageDiv.className = 'message inline-block group cursor-pointer relative max-w-[80%] bg-gray-100 px-4 py-1 rounded-lg shadow-sm';

        const author = document.createElement('span');
        author.className = 'author block text-xs font-semibold text-accent-700';
        author.textContent = message.user.name;

        const content = document.createElement('span');
        content.className = 'content block';
        content.textContent = message.content;

        const button = document.createElement('button');
        button.className = 'reply-btn absolute z-10 -bottom-3 right-[-65px] border border-gray-100 bg-white shadow-xl px-3 py-1 rounded-md text-sm opacity-0 group-hover:opacity-100 transition';
        button.textContent = 'Ответить';

        messageDiv.appendChild(author);
        messageDiv.appendChild(content);
        messageDiv.appendChild(button);
        wrapper.appendChild(messageDiv);

        // --- YES / NO BUTTONS (если игра, хост и нет ответов) 
        if((stage==='game') && isHost && hasNoReplies) {
            wrapper.appendChild(renderYesNoButtons(message.id));
        }

    // --- REPLIES ---    
    }else{
        const parentMessage = document.querySelector(`.message[data-id="${message.parent_id}"]`);
        if (!parentMessage) return;

        const wrapper = parentMessage.parentElement;
        const repliesWrapper = document.createElement('div');
        repliesWrapper.className = 'replies my-3';
        wrapper.appendChild(repliesWrapper);     

        const replyDiv = document.createElement('div'); // ✅ ВАЖНО — в начале

        if (message.type === 'host') {
            replyDiv.className = 'host inline-block ml-8 my-3 bg-cyan-50 font-medium text-gray-800 px-4 py-2 rounded-lg shadow-lg';
            replyDiv.textContent = message.content;

        } else {
            replyDiv.className = 'ml-8 bg-gray-100 rounded-md px-4 py-1 mt-2 inline-block max-w-md';
            const replyAuthor = document.createElement('span');
            replyAuthor.className = 'author block text-xs font-semibold text-accent-700';
            replyAuthor.textContent = message.user.name;

            const replyContent = document.createElement('span');
            replyContent.className = 'block content text-sm';
            replyContent.textContent = message.content;

            replyDiv.appendChild(replyAuthor);
            replyDiv.appendChild(replyContent);
        }

        repliesWrapper.appendChild(replyDiv);

        const actions = wrapper.querySelector('.yes-no-actions');
        actions?.remove();

        return;
    }
    chat.appendChild(wrapper);
}

// Кнопки ведущего - отрисовка 
function renderYesNoButtons(parentId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/message/sent';
    form.className = 'yes_no_buttons flex flex-wrap items-center gap-2 my-3';

    const token = document.querySelector('meta[name="csrf-token"]').content;

    form.innerHTML = `
        <input type="hidden" name="_token" value="${token}">
        <input type="hidden" name="parent_id" value="${parentId}">
        
        ${['Да', 'Нет', 'Не важно', 'Некорректный вопрос'].map(text => `
            <button type="submit" name="content" value="${text}"
                class="px-5 py-1 rounded-lg bg-cyan-50 text-gray-800 font-semibold hover:bg-cyan-100 shadow-lg">
                ${text}
            </button>
        `).join('')}
    `;

    return form;
}

// Кнопки ведущего - действие
function initYesNoButtons() {

    document.addEventListener('submit', async (e) => {
        const form = e.target;

        if (!form.matches('.yes_no_buttons')) return;

        e.preventDefault();

        const submitter = e.submitter;
        if (!submitter) return;

        const content = submitter.value;
        const parentId = form.querySelector('input[name="parent_id"]').value;
        const token = form.querySelector('input[name="_token"]').value;

        try {
            const response=await axios.post('/message/sent', {
                content,
                parent_id: parentId,
                _token: token
            });

            appendMessage(response.data);

            form.remove();

        } catch (error) {
            console.error(error);
        }
    });
}