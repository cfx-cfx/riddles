
export function initTimer() {
    const timer = document.getElementById('main-game-timer');
    if (!timer) return;

    const startsAt = new Date(timer.dataset.startsAt);

    const daysEl = timer.querySelector('[data-days]');
    const hoursEl = timer.querySelector('[data-hours]');
    const minutesEl = timer.querySelector('[data-minutes]');

    function update() {
        const now = new Date();
        let diff = Math.floor((startsAt - now) / 1000); // разница в секундах

        if (diff <= 0) {
            daysEl.textContent = '0';
            hoursEl.textContent = '00';
            minutesEl.textContent = '00';
            return;
        }

        const totalMinutes = Math.floor(diff / 60);

        const days = Math.floor(totalMinutes / (24 * 60));
        const hours = Math.floor((totalMinutes % (24 * 60)) / 60);
        const minutes = totalMinutes % 60;

        daysEl.textContent = days;
        hoursEl.textContent = String(hours).padStart(2, '0');
        minutesEl.textContent = String(minutes).padStart(2, '0');
    }

    update();
    setInterval(update, 60000); // обновляем раз в минуту
}
