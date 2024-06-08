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
                roboto: ['Roboto', 'arial', 'sans-serif'],
            },
            colors: {
                // primary: '#220382',
                // secondary: '#cfe600',
                primary: '#f97316',
                secondary: 'white',
                danger: '#ef4444',
                success: '#22c55e',
                warning: '#eab308',
            },
            screens: {
                'mobile-std': { 'max': '800px' },
                'mobile-lg': { 'min': '801px', 'max': '1024px' },
                'web': { 'min': '1025px' },
            },
        },
    },

    plugins: [
        forms,
        require('tailwind-scrollbar'),
    ],
};
