/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.{js,vue,php}'
  ],
  theme: {
    extend: {
      screens: {
        'mobileSmall': '320px',
        'mobile': '375px',
        'mobileLarge': '425px',
        'tablette': '768px'
      }
    }
  },
  plugins: [],
}