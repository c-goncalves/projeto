<?php
require_once 'layouts/form_fluxo.php';

require_once __DIR__ . '/../../../includes/header.php';
$page_title = "Solicitação de Estágio Curricular - Licenciatura em Matemática";
$feedback = $feedback ?? '';
?>

<div class="flex justify-center mt-4 px-4">
    <section id="content-area" class="bg-white border-l-4 border-[#006633] p-6 rounded-xl shadow w-full">

        <h3 class="text-green-800 text-xl font-semibold mb-4">Termo de Compromisso de Estágio - Licenciatura em Matemática</h3>

        <?php
        // Chama a função da Barra de Navegação de Passos
        imprimir_steps_nav();
        ?>

        <form id="termoForm" action="<?php echo BASE_URL; ?>pages/solicitacoes/scripts/salvar_solicitacao.php" method="POST" enctype="multipart/form-data">

            <?php
            // Chama as funções para imprimir cada seção (fieldset)
            estagiario();
            unidade_concedente();
            
            dados_teste();
            supervisor();
            dados_complementares();
            ?>

        </form>
    </section>
</div>

<?php
imprimir_styles();
imprimir_script_js();

require_once __DIR__ . '/../../../includes/footer.php';
?>