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
                lightMode:{
                    background: "#F5F5F5", 
                    text: "#333333", 
                    primary: "#0066CC",
                    blueHighlight: "#3498DB",
                    pinkHighlight: "#FF6B81",
                },
                darkMode:{
                    background: "#2C3E50", 
                    text: "#ECF0F1",
                    primary: "#0066CC",
                    blueHighlight: "#2980B9",
                    pinkHighlight: "#FF6B81", 
                },
            },
        },
    },

    plugins: [forms],
};
