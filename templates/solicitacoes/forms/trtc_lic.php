<?php
function print_rescisao($BASE_URL, $SERVER_URI, $curso = null) {
    ?>
    <div class="mt-4">
        <div id="form-layout" class="flex flex-col md:flex-row items-start w-full gap-8 mx-auto max-w-[1200px]">
            <nav id="nav-form" class="hidden md:block flex-shrink-0 w-52 pt-4">
                <div class="flex flex-col gap-2">
                    <?php imprimir_steps_nav_rescisao_lic(); ?>
                </div>
            </nav>

            <section id="content-area" class="flex-1 min-w-0 box-border bg-white p-6 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)]">

                <h3 class="text-green-800 text-xl font-semibold mb-4 text-center">Termo de Rescisão do Termo de Compromisso</h3>

                <form id="termoForm" action="<?= $BASE_URL ?>solicitacoes/form/enviar" method="POST" enctype="multipart/form-data">
                    <?php
                    orientacoes_rescisao_lic($SERVER_URI, $BASE_URL);
                    instituicao_concedente_rescisao_lic();
                    aluno_rescisao_lic();
                    estagio_rescisao_lic();
                    assinaturas_rescisao_lic();
                    ?>
                </form>
            </section>
        </div>
    </div>
<?php }

function imprimir_steps_nav_rescisao_lic() { ?>
    <div id="stepsNav">
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="0">Orientações</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="1">Instituição / Concedente</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="2">Dados do Aluno</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="3">Estágio / Rescisão</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="4">Assinaturas</a>
    </div>
<?php }

function orientacoes_rescisao_lic($current_uri, $pages_path) { ?>
    <fieldset data-step="0" class="mb-4">
        <h5 class="text-[#09332a] font-semibold mb-3 text-base text-left">Orientações</h5>
        <ul class="space-y-2 text-sm text-gray-700 list-inside">
            <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span> Verifique os motivos e a documentação da rescisão antes de enviar.</li>
            <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span> Datas informadas devem obedecer ao contrato original.</li>
        </ul>
        <div class="mt-4 text-sm text-gray-700 text-right">
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26] transition-colors">Li e Continuar</button>
        </div>
    </fieldset>
<?php }

function instituicao_concedente_rescisao_lic() { ?>
    <fieldset data-step="1" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Dados da Instituição / Unidade Concedente</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Nome da Instituição</label>
                <input name="nome_instituicao" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Endereço Instituição</label>
                <input name="endereco_instituicao" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Telefone Instituição</label>
                <input name="fone_instituicao" class="w-full border rounded px-3 py-2 text-sm" placeholder="99 9999-9999">
            </div>
            <div>
                <label class="font-semibold text-sm">CNPJ Instituição</label>
                <input name="cnpj_instituicao" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Representante da Instituição</label>
                <input name="representante_instituicao" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2 border-t pt-3">
                <h5 class="font-medium">Dados da Unidade Concedente</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                    <div>
                        <label class="font-semibold text-sm">Nome / Razão Social Concedente</label>
                        <input name="nome_razao_social_concedente" class="w-full border rounded px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="font-semibold text-sm">CNPJ Concedente</label>
                        <input name="cnpj_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Insc. Estadual</label>
                        <input name="insc_estadual_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">CPF (Autônomo)</label>
                        <input name="cpf_autonomo" class="w-full border rounded px-3 py-2 text-sm" placeholder="999.999.999-99">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Endereço Concedente</label>
                        <input name="endereco_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">CEP</label>
                        <input name="cep_concedente" class="w-full border rounded px-3 py-2 text-sm" placeholder="99999-999">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Bairro</label>
                        <input name="bairro_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Cidade</label>
                        <input name="cidade_concedente" class="w-full border rounded px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Estado</label>
                        <input name="estado_concedente" class="w-full border rounded px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Nome do Representante</label>
                        <input name="nome_representante_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Cargo do Representante</label>
                        <input name="cargo_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function aluno_rescisao_lic() { ?>
    <fieldset data-step="2" class="mb-4" style="display:none">
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
                <label class="font-semibold text-sm">Período / Turno</label>
                <input name="periodo_curso_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="Diurno / Matutino / Vespertino / Noturno">
            </div>
            <div>
                <label class="font-semibold text-sm">RG</label>
                <input name="rg_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="99.999.999-9">
            </div>
            <div>
                <label class="font-semibold text-sm">CPF</label>
                <input name="cpf_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="999.999.999-99">
            </div>
            <div>
                <label class="font-semibold text-sm">Data de Nascimento</label>
                <input name="dns_aluno" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Fone</label>
                <input name="fone_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="99 9999-9999">
            </div>
            <div>
                <label class="font-semibold text-sm">Celular</label>
                <input name="celular_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="99 99999-9999">
            </div>
            <div>
                <label class="font-semibold text-sm">E-mail</label>
                <input name="email_aluno" type="email" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Tipo de Estágio</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="inline-flex items-center"><input type="radio" name="tipo_estagio" value="obrigatorio" checked> Obrigatório</label>
                    <label class="inline-flex items-center"><input type="radio" name="tipo_estagio" value="nao_obrigatorio"> Não Obrigatório</label>
                </div>
            </div>

            <div>
                <label class="font-semibold text-sm">PCD</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="inline-flex items-center"><input type="checkbox" name="pcd_aluno" value="1"> Sim</label>
                </div>
            </div>

            <div>
                <label class="font-semibold text-sm">Responsável pela Notificação</label>
                <select name="responsavel_notificacao" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">-- selecione --</option>
                    <option value="concedente">Unidade Concedente</option>
                    <option value="estagiario">Estagiário</option>
                    <option value="ifsp">Instituto Federal - Campus Guarulhos</option>
                </select>
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function estagio_rescisao_lic() { ?>
    <fieldset data-step="3" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Estágio / Rescisão</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Data de Rescisão</label>
                <input name="data_rescicao_estagio" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Data Início do Estágio (original)</label>
                <input name="data_inicio_estagio" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Data Término do Estágio (original)</label>
                <input name="data_termino_estagio" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Data de Assinatura</label>
                <input name="data_assinatura" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function assinaturas_rescisao_lic() { ?>
    <fieldset data-step="4" class="mb-4" style="display:none">
        <h4 class="text-[#006633] font-semibold mb-4">Assinaturas e Testemunhas</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Assinatura do Aluno (nome)</label>
                <input name="assinatura_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Assinatura do Concedente (nome)</label>
                <input name="assinatura_concedente" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Assinatura da Instituição (nome)</label>
                <input name="assinatura_instituicao" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Nome Testemunha 1</label>
                <input name="nome_testemunha_1" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">RG Testemunha 1</label>
                <input name="rg_testemunha_1" class="w-full border rounded px-3 py-2 text-sm" placeholder="99.999.999-9">
            </div>
            <div>
                <label class="font-semibold text-sm">CPF Testemunha 1</label>
                <input name="cpf_testemunha_1" class="w-full border rounded px-3 py-2 text-sm" placeholder="999.999.999-99">
            </div>
            <div>
                <label class="font-semibold text-sm">Nome Testemunha 2</label>
                <input name="nome_testemunha_2" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">RG Testemunha 2</label>
                <input name="rg_testemunha_2" class="w-full border rounded px-3 py-2 text-sm" placeholder="99.999.999-9">
            </div>
            <div>
                <label class="font-semibold text-sm">CPF Testemunha 2</label>
                <input name="cpf_testemunha_2" class="w-full border rounded px-3 py-2 text-sm" placeholder="999.999.999-99">
            </div>

            <div>
                <label class="font-semibold text-sm">Data Assinatura do Aluno</label>
                <input name="data_assinatura_aluno" type="date" class="w-full border rounded px-3 py-2 text-sm">
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
            <button type="submit" class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Enviar</button>
        </div>
    </fieldset>
<?php }

?>
