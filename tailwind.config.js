import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                accent: {
                    100: '#AFF3FF',
                    200: '#6FE3FF',
                    300: '#669df6',
                    400: '#4285f4',
                    500: '#1967d2',
                    600: '#1558b0',
                    700: '#104a93',
                },
                brand: {
                    50: '#FFF4EA',
                    100: '#FFE8D2',
                    200: '#EACFC3',
                    300: '#E1B8A7',
                    400: '#D8A996', // основной
                    500: '#C9927F',
                    600: '#B57B69',
                    700: '#8F5F52',
                    800: '#6A463C',
                    900: '#46302A',
                },
            },
        },
    },

    plugins: [forms],
};
