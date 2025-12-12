<?php
function print_tce($BASE_URL, $SERVER_URI) { ?>
    <div class="w-full mt-4">
        <div id="form-layout" class="flex flex-col md:flex-row items-start mx-auto gap-8 w-full sm:p-1">
            <nav id="nav-form" class="hidden md:block w-1/4 pt-4">
                <div class="flex flex-col gap-2">
                    <?php imprimir_steps_nav(); ?>
                </div>
            </nav>

            <section id="content-area" class="w-full md:w-3/4 bg-white p-6 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)]">
                <h3 class="text-green-800 text-xl font-semibold mb-4 text-center">
                    TCE: Termo de Compromisso de Estágio Obrigatório<br>Licenciatura em Matemática
                </h3>
                
                <form id="termoForm" action="<?= $BASE_URL ?>solicitacoes/form/enviar" method="POST" enctype="multipart/form-data" class="w-100">
                    <?php
                    orientacoes($SERVER_URI, $BASE_URL);
                    unidade_instituicao_concedente();
                    supervisor();
                    estagiario();
                    dados_complementares();
                    assinaturas_section();
                    ?>
                </form>
            </section>
        </div>
    </div>
    
<?php }

function imprimir_steps_nav() { ?>
    <div id="stepsNav">
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="0">Orientações</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="1">Instituição / Concedente</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="2">Supervisor</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="3">Estagiário</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="4">Período e Atividades</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="5">Assinaturas</a>
    </div>
<?php }

function orientacoes($current_uri, $pages_path) { ?>
   <fieldset data-step="0" class="mb-4">
    <h5 class="text-[#09332a] font-semibold mb-3 text-base text-left">Orientações</h5>

    <ul class="space-y-2 text-sm text-gray-700 list-inside">
        <li class="flex gap-2 items-start "><span class="text-[#006633]">➤</span>
            Tenha todas as informações obrigatórias em mãos. Baixe o checklist
            <a href="<?= $ASSETS_URL ?>solicitacao/form/pdf/checklist-termo" class="font-semibold <?php echo strpos($current_uri, '/solicitacao') !== false ? 'active' : ''; ?>">aqui</a>
        </li>
        <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Carga Horária (Cláusula 3.2): O limite máximo de horas é de 6h/dia ou 30h/semana. A jornada <strong>NUNCA</strong> pode coincidir com seu horário de aulas no IFSP.
        </li>
        <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Vigência Máxima (Cláusula 2.2): O prazo máximo de estágio na mesma concedente é de 2 (dois) anos, exceto para estagiários PCD. Verifique condições específicas no regulamento da sua unidade.
        </li>
        <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Rubrica: Verifique se o Termo foi rubricado em TODAS as páginas pelas partes envolvidas.
        </li>
        <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Vínculo: Lembre-se que o estágio não cria vínculo empregatício (Cláusula 4.6). Em caso de dúvidas, consulte o setor responsável pela coordenação de estágios.
        </li>
        <li class="flex gap-2 items-start"><span class="text-[#006633]">➤</span>
            Seguro e documentação: confirme a exigência de apólice de seguro ou declaração de responsabilidade conforme normas internas antes de iniciar o estágio.
        </li>
    </ul>

    <div class="mt-4 p-3 bg-red-50 text-red-700 border-l-4 border-red-500">
        <strong>INÍCIO DO ESTÁGIO:</strong> O estágio somente pode ser iniciado após a aprovação e a obtenção de todas as assinaturas no Termo de Compromisso e no Plano de Atividades.
    </div>
    
    <div class="mt-4 text-sm text-gray-700">
        <div>
            Documentação: Para modelos, normas e mais informações (incluindo seguro), acesse:
            <a href="<?= $pages_path; ?>recursos/" class="text-[#007a4d] underline font-semibold">Área de Recursos</a>
        </div>
    </div>

    <div class="mt-4 text-sm text-gray-700 text-right">
        <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26] transition-colors">Li e Continuar</button>
    </div>
</fieldset>
<?php }

function unidade_instituicao_concedente() { ?>
    <fieldset data-step="1" class="mb-4 hidden">
        <h4 class="text-[#006633] font-semibold mb-4">Dados da Instituição / Unidade Concedente</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Tipo</label>
                <select id="unidade_tipo" name="unidade_tipo" class="w-full border rounded px-3 py-2 text-sm">
                    <option value=""></option>
                    <option value="instituicao">Instituição (IF / Escola)</option>
                    <option value="empresa">Empresa (CNPJ)</option>
                    <option value="autonomo">Autônomo (CPF)</option>
                </select>
            </div>

            <!-- Instituição (separado) -->
            <div class="md:col-span-2 border-t pt-3">
                <h5 class="font-medium">Dados da Instituição (se aplicável)</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                    <div>
                        <label class="font-semibold text-sm">Nome da Instituição</label>
                        <input name="nome_instituicao" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">CNPJ</label>
                        <input name="cnpj_instituicao" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Endereço</label>
                        <input name="endereco_instituicao" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Telefone</label>
                        <input name="fone_instituicao" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-semibold text-sm">Representante Legal</label>
                        <input name="representante_instituicao" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                </div>
            </div>

            <!-- Concedente / Unidade -->
            <div class="md:col-span-2 border-t pt-3">
                <h5 class="font-medium">Dados da Unidade Concedente</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                    <div>
                        <label class="font-semibold text-sm">Nome / Razão Social *</label>
                        <input name="nome_razao_social_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Diretoria de Ensino</label>
                        <input name="diretoria_ensino" class="w-full border rounded px-3 py-2 text-sm" placeholder="(Se particular, informe também CNPJ)">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">CNPJ</label>
                        <input name="cnpj_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Telefone</label>
                        <input name="fone_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-semibold text-sm">Endereço (Logradouro + Número)</label>
                        <input name="endereco_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="font-semibold text-sm">CEP</label>
                        <input name="cep_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Bairro</label>
                        <input name="bairro_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Cidade</label>
                        <input name="cidade_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="font-semibold text-sm">Estado</label>
                        <input name="estado_concedente" class="w-full border rounded px-3 py-2 text-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-semibold text-sm">Nome da Diretora / Responsável</label>
                        <input name="diretora_concedente" class="w-full border rounded px-3 py-2 text-sm" placeholder="(Diretoria de Ensino)">
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

function supervisor() { ?>
    <fieldset data-step="2" class="mb-4 hidden">
        <h4 class="text-[#006633] font-semibold mb-4">Dados do Supervisor de Estágio</h4>

        <div>
            <label class="font-semibold text-sm">Nome completo *</label>
            <input name="nome_professor_estagio" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-2 gap-3 mt-3">
            <div>
                <label class="font-semibold text-sm">CPF *</label>
                <input name="cpf_supervisor" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Cargo *</label>
                <input name="cargo_supervisor" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-3">
            <label class="font-semibold text-sm">Formação Acadêmica</label>
            <input name="formacao_supervisor" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-2 gap-3 mt-3">
            <div>
                <label class="font-semibold text-sm">Registro Profissional</label>
                <input name="registro_supervisor" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Órgão</label>
                <input name="orgao_supervisor" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-3">
            <label class="font-semibold text-sm">E-mail</label>
            <input name="email_supervisor" class="w-full border rounded px-3 py-2 text-sm">
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
            <input name="nome_aluno" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-3 gap-3">
            <div>
                <label class="font-medium text-sm">Curso *</label>
                <input name="curso_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-medium text-sm">Semestre / Período *</label>
                <input name="semestre_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-medium text-sm">Prontuário *</label>
                <input name="prontuario_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="GU9999999">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3 mt-3">
            <div>
                <label class="font-medium text-sm">RG</label>
                <input name="rg_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="99.999.999-9">
            </div>
            <div>
                <label class="font-medium text-sm">CPF</label>
                <input name="cpf_aluno" class="w-full border rounded px-3 py-2 text-sm" placeholder="999.999.999-99">
            </div>
            <div>
                <label class="font-medium text-sm">Data Nascimento</label>
                <input name="dns_aluno" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-3">
            <label class="font-semibold text-sm">CEP *</label>
            <input name="cep_aluno" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-4 gap-3 mt-3">
            <div class="col-span-3">
                <label class="font-semibold text-sm">Endereço *</label>
                <input name="endereco_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Número</label>
                <input name="numero_endereco_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="font-semibold text-sm">Bairro</label>
                <input name="bairro_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="font-semibold text-sm">Cidade</label>
                <input name="cidade_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-4">
                <label class="font-semibold text-sm">Estado</label>
                <input name="estado_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-4 gap-3 mt-3">
            <div>
                <label class="font-semibold text-sm">Fone</label>
                <input name="fone_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-sm">Celular</label>
                <input name="celular_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="font-semibold text-sm">E-mail *</label>
                <input name="email_aluno" type="email" class="w-full border rounded px-3 py-2 text-sm">
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
            <div class="p-3 rounded border-l-4 border-red-500 bg-red-50 mb-3 text-red-700">
                <strong>ATENÇÃO:</strong> Garanta que a carga horária <strong>NÃO EXCEDA 6 horas diárias / 30 horas semanais</strong> e não conflite com o horário de aulas.
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label for="data_inicio_estagio" class="font-semibold text-sm">Data Início <span class="text-red-500">*</span></label>
                    <input id="data_inicio_estagio" name="data_inicio_estagio" type="date" required class="w-full border rounded px-3 py-2 text-sm"/>
                </div>
                <div>
                    <label for="data_termino_estagio" class="font-semibold text-sm">Data Término <span class="text-red-500">*</span></label>
                    <input id="data_termino_estagio" name="data_termino_estagio" type="date" required class="w-full border rounded px-3 py-2 text-sm"/>
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
                                        class="select-chip cursor-pointer border rounded px-2 py-1 text-sm"
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
                        <tr><th class="px-3 py-2 border">Dia</th><th class="px-3 py-2 border">Início</th><th class="px-3 py-2 border">Fim</th><th class="px-3 py-2 border">Ações</th></tr>
                        </thead>
                    <tbody id="horarios_tbody"></tbody>
                </table>

                <input type="hidden" id="estagio_horario_json" name="dias_estagio" value="[]" />

                <p id="total_horas" class="text-lg font-semibold text-gray-700">Total Semanal: 00:00h</p>
                <div class="flex justify-between mt-4">
                    <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
                    <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Continuar</button>
                </div>
            </div>
    </fieldset>
<?php }

function assinaturas_section(){ ?>
    <fieldset data-step="5" class="mb-4 hidden">
        <h4 class="text-[#006633] font-semibold mb-4">Assinaturas</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="font-semibold text-sm">Data de Assinatura do Contrato</label>
                <input name="data_assinatura_contrato" type="date" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Assinatura do Aluno (nome)</label>
                <input name="assinatura_aluno" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Arquivo Assinatura do Aluno (scan/opcional)</label>
                <input type="file" name="assinatura_aluno_file" accept="image/*,application/pdf" class="w-full">
            </div>

            <div>
                <label class="font-semibold text-sm">Assinatura do Concedente (nome)</label>
                <input name="assinatura_concedente" class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="font-semibold text-sm">Arquivo Assinatura do Concedente (scan/opcional)</label>
                <input type="file" name="assinatura_concedente_file" accept="image/*,application/pdf" class="w-full">
            </div>

            <div class="md:col-span-2">
                <label class="font-semibold text-sm">Assinaturas Adicionais / Observações</label>
                <textarea name="assinaturas" class="w-full border rounded px-3 py-2 text-sm" rows="3"></textarea>
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" data-prev class="bg-gray-100 text-[#006633] font-bold px-4 py-2 rounded hover:bg-gray-200">Anterior</button>
            <button type="submit" class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Enviar</button>
        </div>
    </fieldset>
<?php }

?>
