import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            screens: {
                wide: { raw: '(min-width: 1600px)' },
                'below-xl': { raw: '(max-width: 1200px)' },
                'below-lg': { raw: '(max-width: 1100px)' },
                tablet: { raw: '(max-width: 900px)' },
                'small-tablet': { raw: '(max-width: 760px)' },
                phone: { raw: '(max-width: 600px)' },
                'small-phone': { raw: '(max-width: 420px)' },
                'tiny-phone': { raw: '(max-width: 400px)' },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
