const stepsNav = document.getElementById('stepsNav');
const steps = document.querySelectorAll('#stepsNav .step');
const form = document.getElementById('termoForm');
const fieldsets = form.querySelectorAll('fieldset');
const card = document.getElementById('content-area');

let currentStep = 0;

const showStep = (step) => {
    // garante bounds
    if (step < 0) step = 0;
    if (step >= fieldsets.length) step = fieldsets.length - 1;
    currentStep = step;

    // aplica display apenas via style (não mexer em classes utilitárias globais)
    fieldsets.forEach((fs, index) => {
        if (index === step) {
            fs.style.display = 'block';
            fs.style.visibility = 'visible';
            fs.style.opacity = '1';
            fs.setAttribute('aria-hidden', 'false');
        } else {
            fs.style.display = 'none';
            fs.style.visibility = 'hidden';
            fs.style.opacity = '0';
            fs.setAttribute('aria-hidden', 'true');
        }
    });

    // atualiza nav ativo
    steps.forEach(s => s.classList.remove('active'));
    const activeStep = document.querySelector(`#stepsNav .step[data-step="${step}"]`);
    if (activeStep) activeStep.classList.add('active');

    // atualiza o visual do card
    if (step === 0) {
        card.classList.remove('border-green-600');
        card.classList.add('border-red-500');
    } else {
        card.classList.remove('border-red-500');
        card.classList.add('border-green-600');
    }

    // força recalculo de layout mínimo — sem alterar width
    const ca = document.getElementById('content-area');
    if (ca) {
        ca.style.maxWidth = ca.style.maxWidth || getComputedStyle(ca).maxWidth;
    }
};

// --- rebind seguro dos botões next/prev ---
function bindStepButtons() {
    // remove handlers anteriores para evitar duplicação
    form.querySelectorAll('[data-next]').forEach(btn => {
        btn.replaceWith(btn.cloneNode(true));
    });
    form.querySelectorAll('[data-prev]').forEach(btn => {
        btn.replaceWith(btn.cloneNode(true));
    });

    // reselect após clone
    form.querySelectorAll('[data-next]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            // validação do passo 4 antes de avançar
            if (currentStep === 4) {
                const isCurrentStep4 = document.querySelector('fieldset[data-step="4"]').style.display !== 'none';
                if (isCurrentStep4 && !validateStep4()) {
                    e.stopImmediatePropagation();
                    e.preventDefault();
                    return;
                }
            }
            if (currentStep < fieldsets.length - 1) {
                showStep(currentStep + 1);
            }
        });
    });

    form.querySelectorAll('[data-prev]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentStep > 0) {
                showStep(currentStep - 1);
            }
        });
    });
}

// --- inicialização segura ---
document.addEventListener('DOMContentLoaded', function() {
    // garante que fieldsets estejam no estado inicial
    fieldsets.forEach((fs, i) => {
        fs.style.width = '100%';
        fs.style.minWidth = '0';
        // por padrão ocultar todos, mostrar o currentStep
        fs.style.display = (i === currentStep) ? 'block' : 'none';
    });

    // liga nav steps (clique direto)
    steps.forEach(s => {
        s.addEventListener('click', (e) => {
            e.preventDefault();
            const step = parseInt(s.getAttribute('data-step'));
            if (!isNaN(step)) {
                showStep(step);
            }
        });
    });

    // (re)liga botões next/prev
    bindStepButtons();

    // resto das inits
    initializeUnidadeTipoSelector();
    const addButton = document.getElementById('adicionar_horario');
    if (addButton) {
        // garante que não haja listener duplo
        addButton.replaceWith(addButton.cloneNode(true));
        document.getElementById('adicionar_horario').addEventListener('click', addIndividualHorario);
    }

    // garantir render inicial de tabela/total (se houver dados prévios)
    renderTable();
});

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

// INCLUSAO DOS HORÁRIOS
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
        checkboxes.forEach(cb => { cb.checked = false; });
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

// UNIDADE CONCEDENTE
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

// INICIALIZAÇÃO
document.addEventListener('DOMContentLoaded', function() {
    showStep(currentStep);
    initializeUnidadeTipoSelector();
    const addButton = document.getElementById('adicionar_horario');
    if (addButton) {
        addButton.addEventListener('click', addIndividualHorario);
    }
});