<?php
function print_tce($BASE_URL, $SERVER_URI, $curso, $old = [], $erro = null) { 
     switch ($curso){
        case 'lic': $curso = 'Licenciatura em Matemática'; break;
        case 'ads': $curso = 'Tecnologia em Análise e Desenvolvimento de Sistemas'; break;
        case 'tai': $curso = 'Tecnologia em Automação Industrial'; break;
        case 'eg': $curso = 'Engenharia de Computação'; break;
        case 'eca': $curso = 'Engenharia de Controle e Automação'; break;
        default: $curso = ''; break;
    }
    ?>
    <div class="w-full mt-4">
        <div id="form-layout" class="flex flex-col items-start mx-auto gap-8 w-full sm:p-1">
            
            <section id="content-area" class="w-full bg-white p-8 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)] ">
                <h3 class="text-green-800 text-xl font-semibold mb-4 text-center">
                    TCE: Termo de Compromisso de Estágio<br> <?php echo $curso; ?>
                </h3>
                
                <form id="termoForm" action="<?= $BASE_URL ?>solicitacao/enviar" method="POST" enctype="multipart/form-data" class="space-y-10">
                    <?php if ($erro): ?>
                        <div class="p-4 mb-6 bg-red-50 border-l-4 border-red-600 text-red-800 shadow-sm rounded-r">
                            <div class="flex items-start">
                                <div>
                                    <strong class="block mb-1">ERRO:</strong>
                                    <ul class="list-disc list-inside text-sm space-y-1">
                                        <?php 
                                        $listaErros = explode('|', $erro);
                                        foreach ($listaErros as $item): ?>
                                            <li><?= htmlspecialchars(trim($item)) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="doc_type" value="tce">
                    
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <?php orientacoes($SERVER_URI, $BASE_URL); ?>
                    </div>

                    <div>
                        <?php unidade_instituicao_concedente($old); ?>
                    </div>

                    <div class="pt-6 border-t">
                        <?php supervisor($old); ?>
                    </div>

                    <div class="pt-6 border-t">
                        <?php estagiario($old); ?>
                    </div>

                    <div class="pt-6 border-t">
                        <?php dados_complementares($old); ?>
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
    <h5 class="text-[#09332a] font-semibold mb-3 text-base">Orientações Gerais</h5>
    <ul class="space-y-2 text-sm text-gray-700 list-inside">
        <li><span class="text-[#006633] font-bold">➤</span> Carga Horária: Máximo 6h diárias / 30h semanais.</li>
        <li><span class="text-[#006633] font-bold">➤</span> Vigência: Máximo de 2 anos na mesma instituição.</li>
    </ul>
<?php }

function unidade_instituicao_concedente($old = []) { ?>
    <h4 class="text-[#006633] font-semibold mb-4 flex items-center gap-2">
        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
        Unidade Concedente
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="font-semibold text-sm block mb-1">Nome / Razão Social *</label>
            <input name="nome_razao_social_concedente" value="<?= htmlspecialchars($old['nome_razao_social_concedente'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">
        </div>
        <div>
            <label class="font-semibold text-sm block mb-1">CNPJ</label>
            <input name="cnpj_concedente" value="<?= htmlspecialchars($old['cnpj_concedente'] ?? '') ?>" class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div>
            <label class="font-semibold text-sm block mb-1">Telefone</label>
            <input name="fone_concedente" value="<?= htmlspecialchars($old['fone_concedente'] ?? '') ?>" class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div class="md:col-span-2">
            <label class="font-semibold text-sm block mb-1">Endereço Completo</label>
            <input name="endereco_concedente" value="<?= htmlspecialchars($old['endereco_concedente'] ?? '') ?>" class="w-full border rounded px-3 py-2 text-sm">
        </div>
    </div>
<?php }

function supervisor($old = []) { ?>
    <h4 class="text-[#006633] font-semibold mb-4 flex items-center gap-2">
        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
        Dados do Supervisor
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="font-semibold text-sm block mb-1">Nome completo do Supervisor *</label>
            <input name="nome_supervisor" value="<?= htmlspecialchars($old['nome_supervisor'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div>
            <label class="font-semibold text-sm block mb-1">CPF *</label>
            <input name="cpf_supervisor" value="<?= htmlspecialchars($old['cpf_supervisor'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div>
            <label class="font-semibold text-sm block mb-1">Cargo *</label>
            <input name="cargo_supervisor" value="<?= htmlspecialchars($old['cargo_supervisor'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
    </div>
<?php }

function estagiario($old = []) { ?>
    <h4 class="text-[#006633] font-semibold mb-4 flex items-center gap-2">
        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span>
        Dados do Estagiário
    </h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <label class="font-medium text-sm block mb-1">Nome Completo *</label>
            <input name="nome_aluno" value="<?= htmlspecialchars($old['nome_aluno'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div>
            <label class="font-medium text-sm block mb-1">Prontuário *</label>
            <input name="prontuario_aluno" value="<?= htmlspecialchars($old['prontuario_aluno'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm" placeholder="GU9999999">
        </div>
        <div>
            <label class="font-medium text-sm block mb-1">CPF *</label>
            <input name="cpf_aluno" value="<?= htmlspecialchars($old['cpf_aluno'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
        <div class="md:col-span-2">
            <label class="font-medium text-sm block mb-1">E-mail *</label>
            <input name="email_aluno" type="email" value="<?= htmlspecialchars($old['email_aluno'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm">
        </div>
    </div>
<?php }

function dados_complementares($old = []) { ?>
    <h4 class="text-[#006633] font-semibold mb-4 flex items-center gap-2">
        <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">4</span>
        Período e Atividades
    </h4>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label class="font-semibold text-sm block mb-1">Data Início *</label>
            <input name="data_inicio_estagio" type="date" value="<?= htmlspecialchars($old['data_inicio_estagio'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm"/>
        </div>
        <div>
            <label class="font-semibold text-sm block mb-1">Data Término *</label>
            <input name="data_termino_estagio" type="date" value="<?= htmlspecialchars($old['data_termino_estagio'] ?? '') ?>" required class="w-full border rounded px-3 py-2 text-sm"/>
        </div>
    </div>

    <div class="bg-gray-50 p-5 rounded-lg border space-y-4">
        <label class="block text-sm font-bold text-gray-700">Horário Semanal</label>
        
        <select id="select_dias" name="selected_days[]" multiple class="w-full p-2 border rounded text-sm h-32 bg-white">
            <?php 
            $dias = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
            $selecionados = $old['selected_days'] ?? [];
            foreach ($dias as $dia): 
            ?>
                <option value="<?= $dia ?>" <?= in_array($dia, $selecionados) ? 'selected' : '' ?>><?= $dia ?></option>
            <?php endforeach; ?>
        </select>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs text-gray-500">Início</label>
                <input type="time" id="hora_inicio_unico" class="w-full p-2 border rounded text-sm">
            </div>
            <div>
                <label class="text-xs text-gray-500">Término</label>
                <input type="time" id="hora_fim_unico" class="w-full p-2 border rounded text-sm">
            </div>
        </div>

        <div class="flex justify-between items-center p-3 bg-white border rounded">
            <p id="total_horas" class="text-lg font-bold text-gray-700">Total Semanal: 00:00h</p>
            <span id="msg_limite" class="hidden bg-red-100 text-red-700 text-xs px-2 py-1 rounded font-bold">Limite de 30h excedido!</span>
        </div>
        <input type="hidden" id="estagio_horario_json" name="dias_estagio" value='<?= htmlspecialchars($old['dias_estagio'] ?? "[]") ?>' />
    </div>
<?php } ?>