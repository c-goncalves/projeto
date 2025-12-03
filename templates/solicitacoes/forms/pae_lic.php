<?php
function print_pae($BASE_URL, $SERVER_URI, $curso = null) {
    ?>
    <div class="mt-4">
        <div id="form-layout" class="flex flex-col md:flex-row items-start w-full gap-8 mx-auto max-w-[1200px]">
            <nav id="nav-form" class="hidden md:block flex-shrink-0 w-52 pt-4">
                <div class="flex flex-col gap-2">
                    <?php imprimir_steps_nav_multiform(); ?>
                </div>
            </nav>

            <section id="content-area" class="flex-1 min-w-0 box-border bg-white p-6 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)]">

                <h3 class="text-green-800 text-xl font-semibold mb-4 text-center">PAE — Plano de atividades<br>Licenciatura em Matemática</h3>

                <form id="termoForm" action="<?= $BASE_URL ?>solicitacoes/form/enviar" method="POST" enctype="multipart/form-data">
                    <?php
                    orientacoes_multiform($SERVER_URI, $BASE_URL);
                    dados_aluno_multiform();
                    dados_concedente_multiform();
                    supervisao_orientacao_multiform();
                    assinaturas_multiform();
                    ?>
                </form>
            </section>
        </div>
    </div>
<?php }

function imprimir_steps_nav_multiform() { ?>
    <div id="stepsNav">
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="0">Orientações</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="1">Dados do Aluno</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="2">Concedente / Estágio</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="3">Supervisor / Orientador</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="4">Assinaturas</a>
    </div>
<?php }

function orientacoes_multiform($current_uri, $pages_path) { ?>
    <fieldset data-step="0" class="mb-4">
        <h5 class="text-[#09332a] font-semibold mb-3 text-base text-left">Orientações</h5>
        <ul class="space-y-2 text-sm text-gray-700 list-inside">
            <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span> Revise os horários e datas antes de enviar.</li>
            <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span> Selecione corretamente se o estágio é obrigatório ou não.</li>
            <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span> Anexe assinaturas quando disponíveis (scan ou foto).</li>
        </ul>
        <div class="mt-4 text-sm text-gray-700 text-right">
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26] transition-colors">Li e Continuar</button>
        </div>
    </fieldset>
<?php }

function dados_aluno_multiform() { ?>
    <fieldset data-step="1" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Dados do Aluno</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Nome do Aluno</label>
                <input name="nome_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Prontuário</label>
                <input name="prontuario_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="GU9999999" required>
            </div>
            <div>
                <label class="font-semibold text-sm">Curso</label>
                <input name="curso_aluno" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="font-semibold text-sm">Horário do Estágio (ex: 08:00)</label>
                <input name="horario_estagio" type="time" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="font-semibold text-sm">Horário das Aulas (ex: 13:30)</label>
                <input name="horario_aulas_estagio" type="time" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="font-semibold text-sm">Etapa do Estágio</label>
                <input name="etapas_estagio" class="w-full border rounded px-3 py-2 text-sm" placeholder="Ex: Ensino Fundamental / Médio / Infantil">
            </div>
            <div>
                <label class="font-semibold text-sm">Data Início do Estágio</label>
                <input name="data_inicio_estagio" type="date" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="font-semibold text-sm">Data Término do Estágio</label>
                <input name="data_termino_estagio" type="date" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Descrição das Atividades</label>
                <textarea name="descricao_atividades" class="w-full border rounded px-3 py-2 text-sm" rows="4"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Tipo de Estágio</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="inline-flex items-center"><input type="radio" name="tipo_estagio" value="obrigatorio" checked> Obrigatório</label>
                    <label class="inline-flex items-center"><input type="radio" name="tipo_estagio" value="nao_obrigatorio"> Não Obrigatório</label>
                </div>
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function dados_concedente_multiform() { ?>
    <fieldset data-step="2" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Dados da Concedente / Estágio</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Nome / Razão Social</label>
                <input name="nome_razao_social_concedente" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="font-semibold text-sm">Ramo de Atividade (opcional)</label>
                <input name="ramo_de_atividade" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Área do Estágio (opcional)</label>
                <input name="area_estagio" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function supervisao_orientacao_multiform() { ?>
    <fieldset data-step="3" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Supervisor / Orientador</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Nome do Supervisor</label>
                <input name="nome_supervisor" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Cargo do Supervisor</label>
                <input name="cargo_supervisor" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Nome do Orientador (IFSP)</label>
                <input name="nome_orientador" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Banco / Observações</label>
                <input name="banco_orientador" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Data Assinatura do Supervisor</label>
                <input name="data_assinatura_supervisor" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Data Assinatura do Orientador</label>
                <input name="data_assinatura_orientador" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function assinaturas_multiform() { ?>
    <fieldset data-step="4" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Assinaturas</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Assinatura do Aluno (nome)</label>
                <input name="assinatura_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Arquivo Assinatura do Aluno (scan/opcional)</label>
                <input type="file" name="assinatura_aluno_file" accept="image/*,application/pdf" class="w-full">
            </div>

            <div>
                <label class="font-semibold text-sm">Assinatura do Supervisor (nome)</label>
                <input name="assinatura_supervisor" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Arquivo Assinatura do Supervisor (scan/opcional)</label>
                <input type="file" name="assinatura_supervisor_file" accept="image/*,application/pdf" class="w-full">
            </div>

            <div>
                <label class="font-semibold text-sm">Assinatura do Orientador (nome)</label>
                <input name="assinatura_orientador" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Arquivo Assinatura do Orientador (scan/opcional)</label>
                <input type="file" name="assinatura_orientador_file" accept="image/*,application/pdf" class="w-full">
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="submit" class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Enviar</button>
        </div>
    </fieldset>
<?php }

?>
