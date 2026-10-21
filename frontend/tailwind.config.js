/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          DEFAULT: '#171B61',
          sidebar: '#131652',
          dark: '#0D1040',
          light: '#1F257D',
        },
        brand: {
          DEFAULT: '#233DFF',
          hover: '#1B30D9',
          light: '#E5ECFF',
          lavender: '#ECEBFA',
          dark: '#171B61',
        },
        accent: {
          yellow: '#F4CF52',
          blue: '#E5ECFF',
          lavender: '#ECEBFA',
        },
        canvas: '#F4F6FB',
        surface: '#FFFFFF',
        border: '#E8EDF5',
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        'card': '0 4px 20px -2px rgba(23, 27, 97, 0.05), 0 2px 6px -1px rgba(23, 27, 97, 0.02)',
        'glow': '0 0 25px -5px rgba(35, 61, 255, 0.35)',
      },
    },
  },
  plugins: [],
}
