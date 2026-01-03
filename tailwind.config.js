/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        gold: '#B98913',
        'gold-dark': '#8A6508',
        'dark-bg': '#F8FAFC',
        'dark-surface': '#FFFFFF',
      },
    },
  },
  plugins: [],
}

