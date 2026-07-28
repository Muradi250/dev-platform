import Alpine from 'alpinejs';

import 'flowbite';

import { createIcons, icons } from 'lucide';



/*
|--------------------------------------------------------------------------
| Alpine.js
|--------------------------------------------------------------------------
*/

window.Alpine = Alpine;

Alpine.start();



/*
|--------------------------------------------------------------------------
| Lucide Icons
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', () => {

    createIcons({
        icons
    });

});