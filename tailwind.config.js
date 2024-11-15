/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.{css,js}",
    "./templates/**/*.html.twig"
  ],
  theme: {
    colors: {
      'information': '#0057b8',
      'success': '#04b34f',
      'caution': '#ff9900',
      'error': '#a6192e',
      'white': '#ffffff',
      'black': '#000000'
    },
    fontFamily: {
      'satoshi-regular': ["Satoshi-Regular", "sans-serif"],
    },
    extend: {
      fontSize: {
        'h1': '2.25rem',
        'h1-sm': '2.5rem',
        'h1-md': '2.75rem',
        'h1-xl': '3.5rem',

        'h2': '1.75rem',
        'h2-sm': '2rem',
        'h2-md': '2.25rem',
        'h2-xl': '3rem',

        'h3': '1.5rem',
        'h3-sm': '1.75rem',
        'h3-md': '1.9rem',
        'h3-xl': '2.5rem',

        'h4': '1.25rem',
        'h4-sm': '1.5rem',
        'h4-md': '1.6rem',
        'h4-xl': '2rem',

        'h5': '1rem',
        'h5-sm': '1.25rem',
        'h5-md': '1.4rem',
        'h5-xl': '1.75rem',

        'h6': '0.75rem',
        'h6-sm': '1rem',
        'h6-md': '1.15rem',
        'h6-xl': '1.5rem',

        'p-base': '0.66rem',
        'p-sm': '0.875rem',
        'p-md': '0.95rem',
        'p-lg': '1.125rem',
        'p-xl': '1.25rem',
      },
    },
  },
  plugins: [],
}