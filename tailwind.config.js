import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                telkomsel: {
                    50:  '#FFF0F0',
                    100: '#FFD6D8',
                    200: '#FFB3B6',
                    300: '#FF8085',
                    400: '#FF4D54',
                    500: '#ED1C24',
                    600: '#C41018',
                    700: '#9B0D12',
                    800: '#720A0E',
                    900: '#4A060A',
                    950: '#1A0A0B',
                },
                'telkomsel-gold': {
                    300: '#FFD54F',
                    400: '#FFC107',
                    500: '#FFB800',
                },
            },
            keyframes: {
                'float': {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                'float-delayed': {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-15px)' },
                },
                'pulse-glow': {
                    '0%, 100%': { opacity: '0.4', transform: 'scale(1)' },
                    '50%': { opacity: '0.8', transform: 'scale(1.05)' },
                },
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'slide-in-left': {
                    '0%': { opacity: '0', transform: 'translateX(-30px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'float-delayed': 'float-delayed 8s ease-in-out infinite 2s',
                'pulse-glow': 'pulse-glow 4s ease-in-out infinite',
                'fade-in-up': 'fade-in-up 0.6s ease-out forwards',
                'slide-in-left': 'slide-in-left 0.8s ease-out forwards',
            },
        },
    },

    plugins: [forms],
};
