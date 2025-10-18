const colors = require('tailwindcss/colors');

module.exports = {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.{js,ts,vue}',
        './storage/framework/views/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans','ui-sans-serif','system-ui','sans-serif'],
            },
            colors: {
                ...colors,
                primary: colors.indigo,
                secondary: colors.gray,
            },
        },
    },
    corePlugins: { aspectRatio: true },
    safelist: [
        { pattern: /(bg|text|border|ring)-(slate|gray|green|blue)-(50|100|200|300|400|500|600|700|800|900)/, variants: ['hover','dark','dark:hover','group-hover'] },
        { pattern: /(shadow|shadow-(sm|md|lg|xl))/ },
        { pattern: /(aspect-square|line-clamp-\d)/ },
    ],
    plugins: [
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/forms'),
    ],
};
