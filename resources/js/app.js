import { clippingParents } from '@popperjs/core';
import './bootstrap';
import { createIcons, Sun, Moon } from 'lucide';

createIcons({
  icons: {
    Sun,
    Moon
  },
  attrs: {
    'stroke-width': 1.5,
    stroke: 'currentColor'
  }
});


// Dark Mode y Light Mode
document.addEventListener('DOMContentLoaded', () => {
    const btnLight = document.querySelector('#light');
    const btnDark = document.querySelector('#dark');

    // Definiendo evento click
    btnDark.addEventListener('click', (e) => {
        e.preventDefault();
        document.body.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    });

    btnLight.addEventListener('click', (e) => {
        e.preventDefault();
        document.body.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    });

    // Obteniendo LocarlStorage y estableciendo color del sistema
    const localColor = localStorage.getItem('theme');
    const systemColor = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

    if (localColor) {
        if (localColor === 'dark') {
        document.body.classList.add('dark');
        } else {
        document.body.classList.remove('dark');
        }
    } else {
        if (systemColor === 'dark') {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }
    }
    console.log('JavaScript');
});