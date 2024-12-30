/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
  theme: {
    extend: {
      colors: {
        gold: "#FFD700",
        purple: "#0A0B1E",
      },
      spacing: {
        7: "1.75rem", // 28px
        9: "2.25rem", // 36px
        11: "2.75rem", // 44px
        13: "3.25rem", // 52px
        15: "3.75rem", // 60px
      },
    },
  },
  plugins: [],
};
