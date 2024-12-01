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
      'white': '#fbfbff',
      'black': '#000000',

      transparent: "transparent",
      current: "currentColor",
      primary: {
        50: "#FEFCFDff",
        100: "#F9EBF2ff",
        200: "#F0CADBff",
        300: "#E7A8C5ff",
        400: "#DE86AFff",
        500: "#D46598ff",
        600: "#CB4382ff",
        700: "#B9286Bff",
        800: "#9F1455ff",
        900: "#85003Fff",
      },
      gray: {
        50: "#F9FAFB",
        100: "#F3F4F6",
        200: "#E5E7EB",
        300: "#D1D5DB",
        400: "#9CA3AF",
        500: "#6B7280",
        600: "#4B5563",
        700: "#374151",
        800: "#1F2937",
        900: "#111827",
      },
      red: {
        50: "#FEF2F2",
        100: "#FEE2E2",
        200: "#FECACA",
        300: "#FCA5A5",
        400: "#F87171",
        500: "#EF4444",
        600: "#DC2626",
        700: "#B91C1C",
        800: "#991B1B",
        900: "#7F1D1D",
      },
      yellow: {
        50: "#FFFBEB",
        100: "#FEF3C7",
        200: "#FDE68A",
        300: "#FCD34D",
        400: "#FBBF24",
        500: "#F59E0B",
        600: "#D97706",
        700: "#B45309",
        800: "#92400E",
        900: "#78350F",
      },
      green: {
        50: "#ECFDF5",
        100: "#D1FAE5",
        200: "#A7F3D0",
        300: "#6EE7B7",
        400: "#34D399",
        500: "#10B981",
        600: "#059669",
        700: "#047857",
        800: "#065F46",
        900: "#064E3B",
      },
      blue: {
        50: "#EFF6FF",
        100: "#DBEAFE",
        200: "#BFDBFE",
        300: "#93C5FD",
        400: "#60A5FA",
        500: "#3B82F6",
        600: "#2563EB",
        700: "#1D4ED8",
        800: "#1E40AF",
        900: "#1E3A8A",
      },
      indigo: {
        50: "#EEF2FF",
        100: "#E0E7FF",
        200: "#C7D2FE",
        300: "#A5B4FC",
        400: "#818CF8",
        500: "#6366F1",
        600: "#4F46E5",
        700: "#4338CA",
        800: "#3730A3",
        900: "#312E81",
      },
      purple: {
        50: "#FAF5FF",
        100: "#F3E8FF",
        200: "#E9D5FF",
        300: "#D8B4FE",
        400: "#C084FC",
        500: "#A855F7",
        600: "#9333EA",
        700: "#7E22CE",
        800: "#6B21A8",
        900: "#581C87",
      },
      pink: {
        50: "#FDF2F8",
        100: "#FCE7F3",
        200: "#FBCFE8",
        300: "#F9A8D4",
        400: "#F472B6",
        500: "#EC4899",
        600: "#DB2777",
        700: "#BE185D",
        800: "#9D174D",
        900: "#831843",
      },
    },
    fontFamily: {
      'satoshi-regular': ["Satoshi-Regular", "sans-serif"],
    },
    extend: {
      fontSize: {
        'h1': '1.8rem',
        'h1-sm': '2rem',
        'h1-md': '2.2rem',
        'h1-lg': '2.4rem',
        'h1-xl': '2.5rem',

        'h2': '1.6rem',
        'h2-sm': '1.75rem',
        'h2-md': '1.9rem',
        'h2-lg': '2.1rem',
        'h2-xl': '2.3rem',

        'h3': '1.4rem',
        'h3-sm': '1.6rem',
        'h3-md': '1.75rem',
        'h3-lg': '1.9rem',
        'h3-xl': '2.1rem',

        'h4': '1.2rem',
        'h4-sm': '1.4rem',
        'h4-md': '1.5rem',
        'h4-lg': '1.7rem',
        'h4-xl': '1.8rem',

        'h5': '1rem',
        'h5-sm': '1.1rem',
        'h5-md': '1.2rem',
        'h5-lg': '1.4rem',
        'h5-xl': '1.5rem',

        'h6': '0.8rem',
        'h6-sm': '0.9rem',
        'h6-md': '1rem',
        'h6-lg': '1.1rem',
        'h6-xl': '1.2rem',

        'p': '0.8rem',
        'p-sm': '0.9rem',
        'p-md': '0.95rem',
        'p-lg': '1rem',
        'p-xl': '1rem',
      },
    },
  },
  plugins: [],
}