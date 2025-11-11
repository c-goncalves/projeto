<?php
// =============================================
// form_fluxo.php — renderização do fluxo completo
// =============================================

// Garante sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclui helpers de layout
require_once __DIR__ . '/form_steps.php';
require_once __DIR__ . '/form_styles.php';
require_once __DIR__ . '/form_scripts.php';

?>

<div class="flex justify-center mt-4 px-4">
  <section id="content-area" class="bg-white border-l-4 border-[#006633] p-6 rounded-xl shadow w-full">

      <h3 class="text-green-800 text-xl font-semibold mb-4">
          Termo de Compromisso de Estágio - Licenciatura em Matemática
      </h3>

      <?php imprimir_steps_nav(); ?>

      <form id="termoForm" 
            action="<?= BASE_URL ?>solicitacoes/form/enviar" 
            method="POST" 
            enctype="multipart/form-data">

          <?php
          orientacoes($_SERVER['REQUEST_URI'], BASE_URL);
          unidade_concedente();
          supervisor();
          estagiario();
          dados_complementares();
          ?>
      </form>
  </section>
</div>

<?php
imprimir_styles();
imprimir_script_js();
?>
