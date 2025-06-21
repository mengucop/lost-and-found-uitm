/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

// tailwind.config.js
module.exports = {
  darkMode: 'class', // or 'media' if you prefer system-based
  content: ['./resources/**/*.blade.php', './resources/**/*.js'],
  theme: {
    extend: {},
  },
  plugins: [],
}
