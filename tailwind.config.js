import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
  content: [
    './resources/views/**/*.blade.php',
    './app/View/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        ink: '#172026',
        moss: '#28705f',
        coral: '#d75f4f',
        amber: '#d99a2b',
      },
    },
  },
  plugins: [forms],
};
