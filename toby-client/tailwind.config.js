/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        'rgbgray':'rgb(100, 100, 100)',
        'primary': '#232323232',

      },
      
    },
  },
  plugins: [],
};
