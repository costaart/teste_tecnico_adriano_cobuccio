/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  safelist: [
    'text-green-600',
    'text-blue-600',
    'text-red-500',
    'text-orange-500',
  ],
  plugins: [],
}
