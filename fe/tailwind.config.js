/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
      colors: {
        primary: {
          DEFAULT: '#4E240B',
          dark: '#3F1D09',
          light: '#8E5542',
        },
        cream: {
          DEFAULT: '#F5F6E4',
          light: '#FAFAF5',
          dark: '#EAEBD5',
        },
        secondary: {
          DEFAULT: '#1C1817',
          light: '#2A2522',
        },
        white: {
          DEFAULT: '#FFFFFF'
        },
        accent: '#F59E0B',
      },
      boxShadow: {
        soft: '0 8px 20px rgba(78, 36, 11, 0.2)',
      },
      keyframes: {
        fadeIn: {
          from: { opacity: '0', transform: 'translateY(20px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        slideInLeft: {
          from: { opacity: '0', transform: 'translateX(-40px)' },
          to: { opacity: '1', transform: 'translateX(0)' },
        },
      },
      animation: {
        'fade-in': 'fadeIn 0.6s ease-out',
        'slide-in-left': 'slideInLeft 0.6s ease-out',
      },
    },
  },
  plugins: [],
}
