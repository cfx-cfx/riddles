import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { initTimer } from './timer';
import { initChat } from './chat';

document.addEventListener('DOMContentLoaded', () => {
    initTimer();
    initChat();
});

