/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.{js,vue,php}'
  ],
  theme: {
    extend: {
      aspectRatio: {
        '3/1': '3 / 1'
      },
      screens: {
        'mobileSmall': '320px',
        'mobile': '375px',
        'mobileLarge': '425px',
        'tablette': '768px'
      },
      keyframes: {
        shimmer: {
          '100%': { transform: 'translateX(100%)' }
        }
      },
      animation: {
        shimmer: 'shimmer 1.4s infinite'
      }
    }
  },
  plugins: [],
}