<?php

function print_termo_licenciatura_page($BASE_URL, $SERVER_URI) { ?>
    <div class=" mt-4">
        
        <div id="form-layout" class="flex flex-col md:flex-row items-start w-full gap-8 mx-auto max-w-[1200px]">
            
            <nav id="nav-form" class="hidden md:block flex-shrink-0 w-52 pt-4">
                <div class="flex flex-col gap-2">
                    <?php imprimir_steps_nav(); ?>
                </div>
            </nav>

            <section id="content-area" class="w-100 bg-white p-6 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)]">

                <h3 class="text-green-800 text-xl font-semibold mb-4 text-center">
                    TCE: Termo de Compromisso de Estágio Obrigatório<br>Licenciatura em Matemática
                </h3>
                
                <form id="termoForm" action="<?= $BASE_URL ?>solicitacoes/form/enviar" method="POST" enctype="multipart/form-data">
                    <?php
                    orientacoes($SERVER_URI, $BASE_URL); 
                    unidade_concedente();
                    supervisor();
                    estagiario();
                    dados_complementares();
                    ?>
                </form>
            </section>
        </div>
    </div>
<?php }

function imprimir_steps_nav() { ?>
    <div id="stepsNav">
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="0">Orientações</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="1">Unidade Concedente</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="2">Supervisor</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="3">Estagiário</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="4">Dados Complementares</a>
    </div>
<?php }

function orientacoes($current_uri, $pages_path) { ?>
   <fieldset data-step="0" class="mb-4">
    <h5 class="text-[#09332a] font-semibold mb-3 text-base text-left">Orientações</h5>

    <ul class="space-y-2 text-sm text-gray-700 list-inside">
        
        <li class="flex gap-2 items-start "><span class="text-[#006633]">➤</span>
            Tenha todas as informações obrigatorias em mãos. Baixe o checklist
            <a href="<?php echo BASE_URL; ?>solicitacao/form/pdf/checklist-termo" class="font-semibold <?php echo strpos($current_uri, '/solicitacao') !== false ? 'active' : ''; ?>">aqui
            </a>
        </li>
        <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Carga Horária (Cláusula 3.2): O limite máximo de horas é de 6h/dia ou 30h/semana. A jornada NUNCA pode coincidir com seu horário de aulas no IFSP.
        </li>
        
        <!-- <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Vigência Máxima (Cláusula 2.2):
            <p>O prazo máximo de estágio na mesma concedente é de 2 (dois) anos, exceto para estagiários PCD.</p>
        </li> -->
        
        <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Rubrica:
            <p>Verifique se o Termo foi rubricado em TODAS as páginas pelas partes envolvidas.</p>
        </li>
        
        <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Vínculo:
            <p>Lembre-se que o estágio não cria vínculo empregatício (Cláusula 4.6).</p>
        </li>
    </ul>

    <div class="mt-4 p-3 bg-red-50 text-red-700 border-l-4 border-red-500">
        INÍCIO DO ESTÁGIO: O estágio somente pode ser iniciado após a aprovação e a obtenção de todas as assinaturas no Termo de Compromisso e no Plano de Atividades.
    </div>
    
    <div class="mt-4 text-sm text-gray-700">
        <div>
            Documentação: Para modelos, normas e mais informações (incluindo seguro), acesse:
            <a href="<?= $pages_path; ?>recursos/" class="text-[#007a4d] underline font-semibold">
                Área de Recursos
            </a>
    </div>
    <div class="mt-4 text-sm text-gray-700 text-right">
        <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26] transition-colors">Li e Continuar</button>
    </div>
</fieldset>
<?php }

function unidade_concedente() { ?>
    <fieldset data-step="1" class="mb-4 hidden">
        <h4 class="text-[#006633] font-semibold mb-4">Dados da Unidade Concedente</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Tipo</label>
                <select id="unidade_tipo" name="unidade_tipo" class="w-full border rounded px-3 py-2 text-sm">
                    <option value=""></option>
                    <option value="empresa">Empresa (CNPJ)</option>
                    <option value="autonomo">Autônomo (CPF)</option>
                </select>
            </div>

            <div id="campos-empresa" class="md:col-span-2 grid grid-cols-2 gap-3 hidden">
                <div>
                    <label class="font-semibold text-sm">CNPJ *</label>
                    <input id="unidade_cnpj" name="unidade_cnpj" class="w-full border rounded px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="font-semibold text-sm">Insc. Estadual</label>
                    <input id="unidade_insc_estadual" name="unidade_insc_estadual" class="w-full border rounded px-3 py-2 text-sm">
                </div>
            </div>

            <div id="campos-autonomo" class="md:col-span-2 grid grid-cols-2 gap-3 hidden">
                <div>
                    <label class="font-semibold text-sm">CPF *</label>
                    <input id="unidade_cpf_autonomo" name="unidade_cpf_autonomo" class="w-full border rounded px-3 py-2 text-sm">
                </div>
            </div>

            <div>
                <label class="font-semibold text-sm">Razão Social *</label>
                <input id="unidade_nome" name="unidade_nome" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Telefone</label>
                <input id="unidade_telefone" name="unidade_telefone" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="font-semibold text-sm">CEP *</label>
                <input id="unidade_cep" name="unidade_cep" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2 grid grid-cols-4 gap-3">
                <div class="col-span-3">
                    <label class="font-semibold text-sm">Endereço</label>
                    <input name="unidade_endereco" class="w-full border rounded px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="font-semibold text-sm">Número</label>
                    <input name="unidade_numero" class="w-full border rounded px-3 py-2 text-sm">
                </div>
                <div class="col-span-2">
                    <label class="font-semibold text-sm">Bairro</label>
                    <input name="unidade_bairro" class="w-full border rounded px-3 py-2 text-sm">
                </div>
                <div class="col-span-2">
                    <label class="font-semibold text-sm">Cidade</label>
                    <input name="unidade_cidade" class="w-full border rounded px-3 py-2 text-sm">
                </div>
                <div class="col-span-4">
                    <label class="font-semibold text-sm">Estado</label>
                    <input name="unidade_estado" class="w-full border rounded px-3 py-2 text-sm">
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Representante Legal *</label>
                <input name="unidade_representante" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function supervisor() { ?>
    <fieldset data-step="2" class="mb-4 hidden">
        <h4 class="text-[#006633] font-semibold mb-4">Dados do Supervisor de Estágio</h4>

        <div>
            <label class="font-semibold text-sm">Nome completo *</label>
            <input name="supervisor_nome" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-2 gap-3 mt-3">
            <div>
                <label class="font-semibold text-sm">CPF *</label>
                <input name="supervisor_cpf" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Cargo *</label>
                <input name="supervisor_cargo" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-3">
            <label class="font-semibold text-sm">Formação Acadêmica</label>
            <input name="supervisor_formacao" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-2 gap-3 mt-3">
            <div>
                <label class="font-semibold text-sm">Registro Profissional</label>
                <input name="supervisor_registro" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Órgão</label>
                <input name="supervisor_orgao" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-3">
            <label class="font-semibold text-sm">E-mail</label>
            <input name="supervisor_email" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }

function estagiario() { ?>
    <fieldset data-step="3" class="mb-4 hidden">
        <h4 class="text-[#006633] font-semibold mb-4">Dados do Estagiário</h4>

        <div class="mb-3">
            <label class="font-medium text-sm">Nome Completo *</label>
            <input name="estagiario_nome" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-3 gap-3">
            <div>
                <label class="font-medium text-sm">Curso *</label>
                <input name="estagiario_curso_nome" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-medium text-sm">Período *</label>
                <input name="estagiario_curso_periodo" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-medium text-sm">Prontuário *</label>
                <input name="estagiario_curso_prontuario" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-3">
            <label class="font-semibold text-sm">CEP *</label>
            <input name="estagiario_cep" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-4 gap-3 mt-3">
            <div class="col-span-3">
                <label class="font-semibold text-sm">Endereço *</label>
                <input name="estagiario_endereco" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Número *</label>
                <input name="estagiario_numero" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="font-semibold text-sm">Bairro *</label>
                <input name="estagiario_bairro" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="font-semibold text-sm">Cidade *</label>
                <input name="estagiario_cidade" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-4">
                <label class="font-semibold text-sm">Estado *</label>
                <input name="estagiario_estado" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-4 gap-3 mt-3">
            <div>
                <label class="font-semibold text-sm">Fone</label>
                <input name="estagiario_fone" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Cel</label>
                <input name="estagiario_cel" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="font-semibold text-sm">E-mail *</label>
                <input name="estagiario_email" type="email" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-3 flex items-center gap-2">
            <input type="checkbox" id="estagiario_pcd" name="estagiario_pcd">
            <label class="text-sm" for="estagiario_pcd">Pessoa com deficiência (PCD)</label>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
        </div>
    </fieldset>
<?php }


function dados_complementares() { ?>
    <fieldset data-step="4" class="mb-4 hidden">
            <h4 class="text-[#006633] font-semibold mb-3">Período e Atividades do Estágio</h4>
            <div class="p-3 rounded border-l-4 border-red-500 bg-red-50 text-red-700 mb-3">
                <strong>ATENÇÃO:</strong> Garanta que a carga horária <strong>NÃO EXCEDA 6 horas diárias / 30 horas semanais</strong> e não conflite com o horário de aulas.
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label for="estagio_inicio" class="font-semibold text-sm">Data Início <span class="text-red-500">*</span></label>
                    <input id="estagio_inicio" name="estagio_inicio" type="date" required class="w-full border rounded px-3 py-2 text-sm"/>
                </div>
                <div>
                    <label for="estagio_fim" class="font-semibold text-sm">Data Término <span class="text-red-500">*</span></label>
                    <input id="estagio_fim" name="estagio_fim" type="date" required class="w-full border rounded px-3 py-2 text-sm"/>
                </div>
            </div>

            <div class="mt-4 p-4 border rounded-md bg-gray-50">
                <h5 class="font-semibold text-sm text-[#006633] mb-3">Definição da Carga Horária Semanal:</h5>
                
                <h6 class="font-medium text-sm text-gray-700 mb-2">Adicionar Horários:</h6>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end mb-3">
                    
                    <div class="md:col-span-2"> <label class="font-medium text-sm mb-1 block">Dia(s) da Semana</label>
                        <div id="dias_checkbox_group" class="flex flex-wrap gap-2">
                            
                            <?php 
                            $dias = [
                                'Segunda' => 'Segunda',
                                'Terca' => 'Terça', 
                                'Quarta' => 'Quarta', 
                                'Quinta' => 'Quinta', 
                                'Sexta' => 'Sexta', 
                                'Sabado' => 'Sábado'
                            ]; 
                            foreach ($dias as $value => $label): 
                            ?>
                                <div class="chip-container">
                                    <input 
                                        type="checkbox" 
                                        id="dia_<?php echo strtolower($value); ?>" 
                                        value="<?php echo $value; ?>" 
                                        name="selected_days[]"
                                        class="hidden" 
                                    />
                                    <label 
                                        for="dia_<?php echo strtolower($value); ?>" 
                                        class="select-chip"
                                    >
                                        <?php echo $label; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            
                        </div>
                    </div>

                    <div>
                        <label for="input_hora_inicio" class="font-medium text-sm">Início</label>
                        <input type="time" id="input_hora_inicio" class="w-full p-2 border rounded text-sm"/>
                    </div>

                    <div>
                        <label for="input_hora_fim" class="font-medium text-sm">Fim</label>
                        <input type="time" id="input_hora_fim" class="w-full p-2 border rounded text-sm"/>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end mb-3">
                    <div class="md:col-span-2"></div>
                    <div class="md:col-span-2">
                        <button type="button" id="adicionar_horario" class="w-full bg-[#006633] text-white font-bold p-2 rounded hover:bg-[#004d26] transition-colors mt-2 md:mt-0">
                            Adicionar Horário(s)
                        </button>
                    </div>
                </div>
                <table class="w-full text-left border border-gray-200 rounded-lg">
                    <thead>
                        </thead>
                    <tbody id="horarios_tbody">
                    </tbody>
                </table>
                <p id="total_horas" class="text-lg font-semibold text-gray-700">Total Semanal: 00:00h</p>
                <div class="flex justify-between mt-4">
                    <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
                    <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Enviar</button>
                </div>
            </fieldset>
<?php }


?>