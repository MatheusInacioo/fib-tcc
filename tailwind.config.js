import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', 'arial', 'sans-serif'],
                roboto:  ['Roboto', 'arial', 'sans-serif'],
            },
            colors: {
                primary: '#f97316',
                secondary: 'white',
                danger: '#ef4444',
                success: '#22c55e',
                warning: '#eab308',
            },
        },
    },

    plugins: [
        forms,
        require('tailwind-scrollbar'),
    ],
};
