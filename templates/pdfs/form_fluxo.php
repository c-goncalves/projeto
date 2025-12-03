<?php

function imprimir_steps_nav() { ?>
    <div id="stepsNav" class="flex justify-between mb-6 hidden">
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="0">Orientações</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="1">Unidade Concedente</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="2">Supervisor</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="3">Estagiário</a>
        <a href="#" class="step text-sm font-medium text-gray-500 px-3 py-1 rounded" data-step="4">Dados Complementares</a>
    </div>
<?php }

function orientacoes($current_uri, $pages_path) { ?>
    <fieldset data-step="0" class="mb-4">
        <h5 class="text-[#09332a] font-semibold mb-2 text-sm">ATENÇÃO AOS PONTOS CRUCIAIS:</h5>

        <ul class="space-y-1 text-sm text-gray-700">
            <li class="flex gap-2"><span class="text-[#006633]">➤</span>Preencha todos os campos corretamente.</li>
            <li class="flex gap-2"><span class="text-[#006633]">➤</span>O termo deverá ter rubrica em todas as páginas.</li>
            <li class="flex gap-2"><span class="text-[#006633]">➤</span>Máx: 6h/dia — 30h/semana.</li>
            <li class="flex gap-2"><span class="text-[#006633]">➤</span>Não pode coincidir com horário de aula.</li>
            <li class="flex gap-2"><span class="text-[#006633]">➤</span>Se houver outro estágio, máximo cumulativo.</li>
            <li class="flex gap-2"><span class="text-[#006633]">➤</span>Não iniciar antes de todas as assinaturas.</li>
            <li class="flex gap-2">
                <span class="text-[#006633]">➤</span>
                Recursos:
                <a href="<?= $pages_path; ?>recursos/" class="text-[#007a4d] underline <?= strpos($current_uri, '/pages/recursos/')!==false?'font-bold':'' ?>">
                    Clique aqui
                </a>
            </li>
        </ul>

        <div class="mt-3 p-3 bg-red-50 text-red-700 border-l-4 border-red-500">
            <strong>IMPORTANTE:</strong> O estágio só inicia após todas as assinaturas do Termo e do Plano.
        </div>

        <div class="flex justify-end mt-4">
            <button type="button" data-next class="bg-[#006633] text-white font-bold px-4 py-2 rounded hover:bg-[#004d26]">Li e Continuar</button>
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
        </div>
    </fieldset>
<?php }

function imprimir_styles() {
    ?>
    <style>
        #stepsNav .step.active {
            background-color: #006633;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        #stepsNav .step:hover:not(.active) {
            background-color: #78BE20;
            color: white;
        }

        .select-chip {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        
        background-color: #e5e7eb;
        color: #4b5563;
        border: 1px solid #d1d5db;
        
        transition: all 0.2s ease-in-out;
        }

        .select-chip:hover {
        background-color: #d1d5db;
        color: #1f2937;
        }

        input[type="checkbox"]:checked + .select-chip {
        background-color: #006633;
        color: white;
        border-color: #004d26; 
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
    </style>
    <?php
}

function imprimir_script_js() {
    ?>
    <script>
        const stepsNav = document.getElementById('stepsNav');
        const steps = document.querySelectorAll('#stepsNav .step');
        const form = document.getElementById('termoForm');
        const fieldsets = form.querySelectorAll('fieldset');
        const card = document.getElementById('content-area');

        let currentStep = 0;

        const showStep = (step) => {
            fieldsets.forEach((fs, index) => {
                fs.style.display = index === step ? 'block' : 'none';
            });

            stepsNav.classList.toggle('hidden', step === 0);

            steps.forEach(s => s.classList.remove('active'));
            const activeStep = document.querySelector(`#stepsNav .step[data-step="${step}"]`);
            if (activeStep) activeStep.classList.add('active');

            if (step === 0) {
                card.classList.remove('border-green-600');
                card.classList.add('border-red-500');
            } else {
                card.classList.remove('border-red-500');
                card.classList.add('border-green-600');
            }
        };

        steps.forEach(s => {
            s.addEventListener('click', (e) => {
                e.preventDefault();
                const step = parseInt(s.getAttribute('data-step'));
                if (!isNaN(step)) {
                    currentStep = step;
                    showStep(currentStep);
                }
            });
        });
        
        form.querySelectorAll('[data-next]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                if (currentStep === 4) {
                    const isCurrentStep4 = document.querySelector('fieldset[data-step="4"]').style.display !== 'none';
                    if (isCurrentStep4 && !validateStep4()) {
                        e.stopImmediatePropagation();
                        e.preventDefault();
                        return;
                    }
                }
                
                if (currentStep < fieldsets.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        form.querySelectorAll('[data-prev]').forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });
        
        
        let horariosEstagio = [];
        const LIMITE_SEMANAL_HORAS = 30;

        function timeToMinutes(time) {
            const [hours, minutes] = time.split(':').map(Number);
            return hours * 60 + minutes;
        }

        function calculateTotalHours() {
            let totalMinutes = 0;
            
            horariosEstagio.forEach(item => {
                const start = timeToMinutes(item.inicio);
                const end = timeToMinutes(item.fim);
                let duration = end - start;
                if (duration < 0) {
                    duration += 24 * 60;
                }
                totalMinutes += duration;
            });

            const totalHours = Math.floor(totalMinutes / 60);
            const remainingMinutes = totalMinutes % 60;

            const totalDisplay = `${String(totalHours).padStart(2, '0')}:${String(remainingMinutes).padStart(2, '0')}h`;
            
            const totalElement = document.getElementById('total_horas');
            if (totalElement) {
                totalElement.textContent = `Total Semanal: ${totalDisplay}`;

                if (totalHours > LIMITE_SEMANAL_HORAS) {
                    totalElement.classList.remove('text-gray-700');
                    totalElement.classList.add('text-red-600');
                } else {
                    totalElement.classList.remove('text-red-600');
                    totalElement.classList.add('text-gray-700');
                }
            }

            const jsonElement = document.getElementById('estagio_horario_json');
            if (jsonElement) {
                jsonElement.value = JSON.stringify(horariosEstagio);
            }
            
            return totalHours;
        }

        function renderTable() {
            const tbody = document.getElementById('horarios_tbody');
            if (!tbody) return; 

            tbody.innerHTML = '';
            
            const baseClasses = 'px-4 py-2 text-sm text-gray-700 border-r'; 

            horariosEstagio.forEach((item, index) => {
                const row = tbody.insertRow();
                const cellClasses = baseClasses + (index > 0 ? '' : ' border-t'); 
                
                row.insertCell(0).className = cellClasses;
                row.cells[0].textContent = item.dia;
                
                row.insertCell(1).className = cellClasses;
                row.cells[1].textContent = item.inicio;
                
                row.insertCell(2).className = cellClasses;
                row.cells[2].textContent = item.fim;

                const actionCell = row.insertCell(3);
                actionCell.className = baseClasses;
                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remover';
                removeButton.classList.add('text-red-500', 'hover:text-red-700', 'text-xs', 'font-medium', 'transition-colors');
                removeButton.onclick = () => removeHorario(index);
                actionCell.appendChild(removeButton);
            });
            
            calculateTotalHours();
        }

        function removeHorario(index) {
            horariosEstagio.splice(index, 1);
            renderTable();
        }
        
        function addHorario(dia, inicio, fim, isBulkAdd = false) {
            if (!dia || !inicio || !fim) {
                if (!isBulkAdd) alert('Por favor, preencha todos os campos de horário.');
                return false;
            }
            
            const inicioMin = timeToMinutes(inicio);
            const fimMin = timeToMinutes(fim);
            const limiteDiario = 6 * 60; 


            if (inicioMin >= fimMin) {
                console.error("Erro: Início maior ou igual ao Fim.");
                if (!isBulkAdd) alert(`O Horário de Início deve ser ANTES do Horário de Fim em ${dia}.`);
                return false;
            }

            let duration = fimMin - inicioMin;
            if (duration < 0) {
                duration += 24 * 60; 
            }
            

            if (duration > limiteDiario) {
                console.error(`Erro: Duração (${duration} min) excede o limite (${limiteDiario} min).`);
                if (!isBulkAdd) alert(`A carga horária de ${dia} (${duration / 60}h) NÃO PODE ultrapassar 6 horas.`);
                return false;
            }

            const existingIndex = horariosEstagio.findIndex(h => h.dia === dia);
            if (existingIndex !== -1) {
                console.error("Erro: Duplicação detectada.");
                if (!isBulkAdd) alert(`Já existe um horário registrado para ${dia}. Por favor, remova o anterior antes de adicionar um novo.`);
                return false;
            }

            horariosEstagio.push({ dia, inicio, fim });
            return true;
        }

        function addIndividualHorario() {
            const checkboxes = document.querySelectorAll('#dias_checkbox_group input[type="checkbox"]:checked');
            const inicio = document.getElementById('input_hora_inicio').value;
            const fim = document.getElementById('input_hora_fim').value;

            const diasSelecionados = Array.from(checkboxes).map(cb => cb.value);

            if (diasSelecionados.length === 0 || !inicio || !fim) {
                alert('Por favor, selecione pelo menos um dia, horário de início e horário de fim.');
                return;
            }
            
            let sucesso = true;
            let diasComErro = [];
            diasSelecionados.forEach(dia => {
                if (!addHorario(dia, inicio, fim, true)) {
                    sucesso = false;
                    diasComErro.push(dia);
                }
            });

            if (sucesso) {
                checkboxes.forEach(cb => {
                    cb.checked = false; 
                });
                document.getElementById('input_hora_inicio').value = '';
                document.getElementById('input_hora_fim').value = '';
                renderTable();
            } else {
                alert(`Não foi possível adicionar horários para: ${diasComErro.join(', ')}. Verifique as regras (6h/dia ou duplicação).`);
                renderTable();
            }
        }
        
        function validateStep4() {
            const totalHours = calculateTotalHours();

            if (horariosEstagio.length === 0) {
                alert('Por favor, adicione pelo menos um período de horário para o estágio.');
                return false;
            }

            if (totalHours > LIMITE_SEMANAL_HORAS) {
                alert(`Atenção: A carga horária total (${totalHours} horas) excede o limite máximo de ${LIMITE_SEMANAL_HORAS} horas semanais.`);
                return false;
            }
            
            return true;
        }

        function initializeUnidadeTipoSelector() {
            const selector = document.getElementById('unidade_tipo');
            const camposEmpresa = document.getElementById('campos-empresa');
            const camposAutonomo = document.getElementById('campos-autonomo');

            if (!selector || !camposEmpresa || !camposAutonomo) return;

            function toggleCampos() {
                const tipoSelecionado = selector.value;
                camposEmpresa.classList.add('hidden');
                camposAutonomo.classList.add('hidden');

                if (tipoSelecionado === 'empresa') {
                    camposEmpresa.classList.remove('hidden');
                } else if (tipoSelecionado === 'autonomo') {
                    camposAutonomo.classList.remove('hidden');
                }
            }

            selector.addEventListener('change', toggleCampos);
            toggleCampos();
        }

        document.addEventListener('DOMContentLoaded', function() {
            showStep(currentStep); 
            initializeUnidadeTipoSelector();
            const addButton = document.getElementById('adicionar_horario');
            if (addButton) {
                addButton.addEventListener('click', addIndividualHorario);
            }
        });

    </script>
    <?php
}

?>