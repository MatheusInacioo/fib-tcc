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
                bk_green: '#02362E',
                bk_light_green: '#08b40c',
                bk_dark_green: '#00473B',
                bk_dark_green_hover: '#4d7f76',
                bk_darker_green: '#082c24',
            },
            height: {
                '400': '400px',
                '540': '540px',
                '600': '600px',
                '624': '624px',
                '790': '790px',
                '1k': '1000px',
            },

            width: {
                '340': '340px',
                '467': '467px',
                '480': '480px',
                '500': '500px',
                '952': '952px',
                'fhd': '1920px',
            },
        },
    },

    plugins: [forms],
};
