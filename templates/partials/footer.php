</main>
<footer style="background-color: var(--verde-escuro); padding: 18px 0; margin-top: 28px; text-align: center; color: var(--branco);">
    <div class="container">
        <p class="small" style="margin-bottom: 8px;">
            Todo o processo de estágio segue as normativas legais vigentes e os regulamentos internos do IFSP Campus Guarulhos.
        </p>
        &copy; <?php echo date('Y'); ?> IFSP - Campus Guarulhos • Coordenação de Estágios.  
        <br>
        <a href="<?php echo BASE_URL; ?>politica-privacidade" style="color: var(--verde-claro); text-decoration: none;">Política de Privacidade</a> |
        <a href="<?php echo BASE_URL; ?>acessibilidade" style="color: var(--verde-claro); text-decoration: none;">Acessibilidade</a>
    </div>
</footer>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          'verde-ifsp': '#006633',
          'verde-claro': '#78BE20',
          'verde-secundario': '#007a4d',
          'verde-escuro': '#09332a',
        }
      }
    }
  }
</script>
</body>
</html>