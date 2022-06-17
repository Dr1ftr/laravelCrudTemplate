const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            
            colors: {
                'mbou-blue-400': '#00AEF0',
                'mbou-blue': '#00AEEF',
                'mbou-blue-500': '#00AEEF',
                'mbou-blue-600': '#1398D3'
            },

            transitionProperty: {
                'size': 'height, width',
                'height': 'height',
                'width': 'width',

                'spacing': 'margin, padding'
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
