/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        gold: '#F5D77A',
        'gold-dark': '#D4B85A',
        'dark-bg': '#070A12',
        'dark-surface': '#0F1419',
      },
    },
  },
  plugins: [],
}

