const colors = require('tailwindcss/colors');

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './storage/framework/views/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        ...colors,
        primary: colors.indigo,
        secondary: colors.gray,
      },
    },
  },
  corePlugins: {
    // aspectRatio is true by default in v4—only override if you’ve turned it off
    aspectRatio: true,
  },
  plugins: [],
};
