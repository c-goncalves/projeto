<?php

function print_pae($BASE_URL, $SERVER_URI) {
    ?>
    <div class="mt-4">
        <div id="form-layout" class="flex flex-col md:flex-row items-start w-full gap-8 mx-auto max-w-[1200px]">
            <nav id="nav-form" class="hidden md:block flex-shrink-0 w-52 pt-4">
                <div class="flex flex-col gap-2">
                    <?php imprimir_steps_nav_aluno(); ?>
                </div>
            </nav>

            <section id="content-area" class="flex-1 min-w-0 box-border bg-white p-6 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)]">

                <h3 class="text-green-800 text-xl font-semibold mb-4 text-center">
                    PAE — Plano de atividades
                </h3>

                <form id="termoForm" action="<?= $BASE_URL ?>solicitacoes/form/enviar" method="POST" enctype="multipart/form-data">
                    <?php
                    orientacoes_aluno($SERVER_URI, $BASE_URL);
                    dados_aluno_estagio();
                    dados_concedente();
                    dados_supervisor_orientador();
                    assinaturas_aluno_supervisor_orientador();
                    ?>
                </form>
            </section>
        </div>
    </div>
<?php }

function imprimir_steps_nav_aluno() { ?>
    <div id="stepsNav">
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="0">Orientações</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="1">Dados do Aluno / Estágio</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="2">Concedente</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="3">Supervisor / Orientador</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="4">Assinaturas</a>
    </div>
<?php }

function orientacoes_aluno($current_uri, $pages_path) { ?>
    <fieldset data-step="0" class="mb-4">
        <h5 class="text-[#09332a] font-semibold mb-3 text-base text-left">Orientações</h5>
        <ul class="space-y-2 text-sm text-gray-700 list-inside">
            <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span> Tenha seus documentos e dados do local de estágio em mãos.</li>
            <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span> Preencha horários com atenção (horário de aulas e horário de estágio).</li>
            <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span> Verifique se a descrição de atividades está clara e objetiva.</li>
        </ul>
        <div class="mt-4 text-sm text-gray-700 text-right">
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26] transition-colors">Li e Continuar</button>
        </div>
    </fieldset>
<?php }

function dados_aluno_estagio() { ?>
    <fieldset data-step="1" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Dados do Aluno e Período de Estágio</h4>

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
                <label class="font-semibold text-sm">Horário do Estágio (início - ex: 08:00)</label>
                <input name="horario_estagio" type="time" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="font-semibold text-sm">Horário das Aulas (início - ex: 13:30)</label>
                <input name="horario_aulas" type="time" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="font-semibold text-sm">Área do Estágio</label>
                <input name="area_estagio" class="w-full border rounded px-3 py-2 text-sm">
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
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function dados_concedente() { ?>
    <fieldset data-step="2" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Dados da Unidade Concedente</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Nome / Razão Social</label>
                <input name="nome_razao_social_concedente" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="font-semibold text-sm">Ramo de Atividade</label>
                <input name="ramo_de_atividade" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Endereço (opcional)</label>
                <input name="endereco_concedente" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Telefone (opcional)</label>
                <input name="fone_concedente" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function dados_supervisor_orientador() { ?>
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
                <label class="font-semibold text-sm">Nome do Orientador</label>
                <input name="nome_orientador" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">E-mail do Supervisor / Orientador</label>
                <input name="email_supervisor_orientador" type="email" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Observações / Banco (se aplicável)</label>
                <input name="banco_orientador" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Data Assinatura do Orientador</label>
                <input name="data_assinatura_orientador" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Data Assinatura do Supervisor</label>
                <input name="data_assinatura_supervisor" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function assinaturas_aluno_supervisor_orientador() { ?>
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