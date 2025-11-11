<?php
$page_title = "Encerrando o Estágio - Avaliação Final";
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../config/db.php';
?>

<div class="grid-alt">
    <section class="" id="content-area">
        <h3 id="encerrando">Encerrando o Estágio</h3>
        <p class="msg error">Funcionalidade Inativa</p>

        <!-- <div class="card" style="margin-top:12px">
            <h4>Encerramento (Protótipo)</h4>
            <p class="msg error">Esta página é um protótipo e a funcionalidade de encerramento ainda não está ativa.</p>
            <form id="encForm" action="../scripts/salvar_encerramento.php" method="POST">
                <div class="row">
                    <div>
                        <label for="encMat">Matrícula</label>
                        <input id="encMat" name="encMat" type="text" />
                    </div>
                    <div>
                        <label for="dataEnc">Data de término</label>
                        <input id="dataEnc" name="dataEnc" type="date" />
                    </div>
                </div>

                <div style="margin-top:12px">
                    <label for="relFinal">Relatório final (resumo)</label>
                    <textarea id="relFinal" name="relFinal"></textarea>
                </div>

                <div style="margin-top:12px" class="form-actions">
                    <button class="btn" type="submit">Enviar Encerramento</button>
                </div>
            </form>
        </div> -->
    </section>

    
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
