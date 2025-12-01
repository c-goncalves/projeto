module.exports = {
  content: [
    "./templates/**/*.php", 
    "./pages/**/*.php",     
    "./index.php",
    "./assets/js/*.js", 
  ],
  theme: {
    extend: {
      colors: {
        'verde-ifsp': '#006633',
        'verde-claro': '#78BE20',
        'verde-secundario': '#007a4d',
        'verde-escuro': '#09332a',
      },
    },
  },
  plugins: [],
}

