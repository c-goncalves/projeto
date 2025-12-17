<?php

function print_tce($BASE_URL, $SERVER_URI, $curso = null) {
    switch ($curso){
        case 'ads': $curso = 'Tecnologia em Análise e Desenvolvimento de Sistemas'; break;
        case 'tai': $curso = 'Tecnologia em Automação Industrial'; break;
        case 'eg':  $curso = 'Engenharia de Computação'; break;
        case 'eca': $curso = 'Engenharia de Controle e Automação'; break;
        default:    $curso = 'Geral'; break;
    }
    ?>

    <div class="w-full mt-4">
        <div id="form-layout" class="flex flex-col items-start w-full gap-8 mx-auto max-w-[1200px]">
            
            <section id="content-area" class="w-full bg-white p-8 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)]">
                
                
                
                <h3 class="text-green-800 text-xl font-semibold mb-4 text-center">
                    TCE: Termo de Compromisso de Estágio<br> <?php echo $curso; ?>
                </h3>
                <form id="termoForm" action="<?= $BASE_URL ?>solicitacao/enviar" method="POST" enctype="multipart/form-data" class="space-y-10">
                    <input type="hidden" name="doc_type" value="tce">
                    
                    <div class="bg-gray-50 p-6 rounded-lg border">
                        <?php orientacoes($SERVER_URI, $BASE_URL); ?>
                    </div>

                    <div>
                        <?php unidade_instituicao_concedente(); ?>
                    </div>

                    <div class="pt-6 border-t">
                        <?php supervisor(); ?>
                    </div>

                    <div class="pt-6 border-t">
                        <?php estagiario(); ?>
                    </div>

                    <div class="pt-6 border-t">
                        <?php dados_complementares(); ?>
                    </div>

                    <div class="pt-8 border-t flex flex-col items-center">
                        <div id="error-message-container" class="hidden w-full mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm flex items-center shadow-sm">
                            <span id="error-message-text"></span>
                        </div>
                        
                        <button type="submit" class="w-full md:w-1/2 bg-[#006633] text-white font-bold py-4 rounded-lg hover:bg-[#004d26] transition-all text-lg shadow-lg">
                            Validar e Gerar Documento (PDF)
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
<?php }

function orientacoes($current_uri, $pages_path) { ?>
    <h5 class="text-[#09332a] font-semibold mb-3 text-base">Orientações Iniciais</h5>
    <ul class="space-y-2 text-sm text-gray-700 list-inside">
        <li><span class="text-[#006633] font-bold">➤</span> Limite de 6h/dia ou 30h/semana.</li>
        <li><span class="text-[#006633] font-bold">➤</span> Vigência máxima de 2 anos na mesma concedente.</li>
        <li><span class="text-[#006633] font-bold">➤</span> O estágio não cria vínculo empregatício.</li>
    </ul>
    <div class="mt-4 p-3 bg-red-50 text-red-700 border-l-4 border-red-500 text-xs">
        <strong>IMPORTANTE:</strong> O estágio só inicia após todas as assinaturas colhidas.
    </div>
<?php }

function unidade_instituicao_concedente() { ?>
    <h4 class="text-[#006633] font-semibold mb-4 flex items-center gap-2 text-lg">
        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
        Dados da Instituição / Unidade Concedente
    </h4>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded border">
            <h5 class="md:col-span-2 font-bold text-gray-600 text-sm uppercase tracking-wider">Instituição de Ensino</h5>
            <div class="md:col-span-2">
                <label class="font-semibold text-xs text-gray-500 uppercase">Nome da Instituição</label>
                <input name="nome_instituicao" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-xs text-gray-500 uppercase">CNPJ</label>
                <input name="cnpj_instituicao" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-xs text-gray-500 uppercase">Telefone</label>
                <input name="fone_instituicao" class="w-full border rounded px-3 py-2 text-sm" placeholder="99 9999-9999">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded border">
            <h5 class="md:col-span-2 font-bold text-gray-600 text-sm uppercase tracking-wider">Unidade Concedente (Empresa/Escola)</h5>
            <div class="md:col-span-2">
                <label class="font-semibold text-xs text-gray-500 uppercase">Nome / Razão Social *</label>
                <input name="nome_razao_social_concedente" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="font-semibold text-xs text-gray-500 uppercase">CNPJ</label>
                <input name="cnpj_concedente" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="font-semibold text-xs text-gray-500 uppercase">Cidade *</label>
                <input name="cidade_concedente" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="font-semibold text-xs text-gray-500 uppercase">Endereço Completo</label>
                <input name="endereco_concedente" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>
    </div>
<?php }

function supervisor() { ?>
    <h4 class="text-[#006633] font-semibold mb-4 flex items-center gap-2 text-lg">
        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
        Dados do Supervisor
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="font-semibold text-xs text-gray-500 uppercase">Nome completo *</label>
            <input name="nome_professor_estagio" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div>
            <label class="font-semibold text-xs text-gray-500 uppercase">CPF *</label>
            <input name="cpf_supervisor" required class="w-full border rounded px-3 py-2 text-sm" placeholder="999.999.999-99">
        </div>
        <div>
            <label class="font-semibold text-xs text-gray-500 uppercase">Cargo *</label>
            <input name="cargo_supervisor" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
    </div>
<?php }

function estagiario() { ?>
    <h4 class="text-[#006633] font-semibold mb-4 flex items-center gap-2 text-lg">
        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span>
        Dados do Estagiário
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <label class="font-medium text-xs text-gray-500 uppercase">Nome Completo *</label>
            <input name="nome_aluno" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div>
            <label class="font-medium text-xs text-gray-500 uppercase">Prontuário *</label>
            <input name="prontuario_aluno" required class="w-full border rounded px-3 py-2 text-sm" placeholder="GU9999999">
        </div>
        <div>
            <label class="font-medium text-xs text-gray-500 uppercase">CPF *</label>
            <input name="cpf_aluno" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div class="md:col-span-2">
            <label class="font-medium text-xs text-gray-500 uppercase">E-mail *</label>
            <input name="email_aluno" type="email" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
    </div>
<?php }

function dados_complementares() { ?>
    <h4 class="text-[#006633] font-semibold mb-4 flex items-center gap-2 text-lg">
        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">4</span>
        Período e Carga Horária
    </h4>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label class="font-semibold text-xs text-gray-500 uppercase">Data Início *</label>
            <input name="data_inicio_estagio" type="date" required class="w-full border rounded px-3 py-2 text-sm"/>
        </div>
        <div>
            <label class="font-semibold text-xs text-gray-500 uppercase">Data Término *</label>
            <input name="data_termino_estagio" type="date" required class="w-full border rounded px-3 py-2 text-sm"/>
        </div>
    </div>

    <div class="bg-gray-50 p-6 rounded-lg border border-dashed border-gray-300 space-y-4">
        <label class="block text-sm font-bold text-gray-700">Configuração de Horário Semanal</label>
        
        <select id="select_dias" name="selected_days[]" multiple class="w-full p-2 border rounded text-sm h-32 bg-white focus:ring-2 focus:ring-green-500">
            <option value="Segunda-feira">Segunda-feira</option>
            <option value="Terça-feira">Terça-feira</option>
            <option value="Quarta-feira">Quarta-feira</option>
            <option value="Quinta-feira">Quinta-feira</option>
            <option value="Sexta-feira">Sexta-feira</option>
            <option value="Sábado">Sábado</option>
        </select>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-[10px] font-bold text-gray-400 uppercase">Início</label>
                <input type="time" id="hora_inicio_unico" class="w-full p-2 border rounded text-sm">
            </div>
            <div>
                <label class="text-[10px] font-bold text-gray-400 uppercase">Término</label>
                <input type="time" id="hora_fim_unico" class="w-full p-2 border rounded text-sm">
            </div>
        </div>

        <div class="flex justify-between items-center p-4 bg-white border rounded shadow-inner">
            <div>
                <p id="total_horas" class="text-xl font-black text-green-800">00:00h</p>
            </div>
            <span id="msg_limite" class="hidden bg-red-600 text-white text-[10px] px-2 py-1 rounded-full font-bold animate-pulse">LIMITE EXCEDIDO</span>
        </div>
        
        <input type="hidden" id="estagio_horario_json" name="dias_estagio" value="[]" />
    </div>
<?php } ?>