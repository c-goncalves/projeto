
const LIMITE_SEMANAL_HORAS = 30;
const LIMITE_DIARIO_MINUTOS = 6 * 60;



function mostrarErro(mensagem) {
    const container = document.getElementById('error-message-container');
    const textSpan = document.getElementById('error-message-text');
    
    if (container && textSpan) {
        textSpan.textContent = mensagem;
        container.classList.remove('hidden');
        container.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        alert(mensagem); 
    }
}


function esconderErro() {
    const container = document.getElementById('error-message-container');
    if (container) container.classList.add('hidden');
}


function timeToMinutes(time) {
    if (!time) return 0;
    const [hours, minutes] = time.split(':').map(Number);
    return (hours * 60) + minutes;
}


function calcularHorarios() {
    const selectDias = document.getElementById('select_dias');
    const inputInicio = document.getElementById('hora_inicio_unico');
    const inputFim = document.getElementById('hora_fim_unico');
    const totalDisplay = document.getElementById('total_horas');
    const detalheDisplay = document.getElementById('detalhe_calculo');
    const msgLimite = document.getElementById('msg_limite');
    const jsonInput = document.getElementById('estagio_horario_json');

    if (!selectDias || !inputInicio || !inputFim) return;

    const diasSelecionados = Array.from(selectDias.selectedOptions).map(opt => opt.value);
    const inicio = inputInicio.value;
    const fim = inputFim.value;

    if (diasSelecionados.length > 0 && inicio && fim) {
        const minInicio = timeToMinutes(inicio);
        const minFim = timeToMinutes(fim);
        let duracaoDiariaMin = minFim - minInicio;

        if (duracaoDiariaMin <= 0) {
            totalDisplay.textContent = "Erro: Início deve ser antes do fim";
            totalDisplay.classList.add('text-red-600');
            return;
        }

        const totalSemanalMin = duracaoDiariaMin * diasSelecionados.length;
        const hTotal = Math.floor(totalSemanalMin / 60);
        const mTotal = totalSemanalMin % 60;
        const hDiaria = (duracaoDiariaMin / 60).toFixed(1);

        totalDisplay.textContent = `Total Semanal: ${String(hTotal).padStart(2, '0')}:${String(mTotal).padStart(2, '0')}h`;
        if (detalheDisplay) detalheDisplay.textContent = `${diasSelecionados.length} dias x ${hDiaria}h por dia`;

        if (hTotal > LIMITE_SEMANAL_HORAS) {
            totalDisplay.classList.add('text-red-600');
            if (msgLimite) msgLimite.classList.remove('hidden');
        } else {
            totalDisplay.classList.remove('text-red-600');
            if (msgLimite) msgLimite.classList.add('hidden');
        }

        const dadosParaApi = diasSelecionados.map(dia => ({
            dia: dia,
            inicio: inicio,
            fim: fim
        }));
        jsonInput.value = JSON.stringify(dadosParaApi);

    } else {
        totalDisplay.textContent = "Total Semanal: 00:00h";
        if (detalheDisplay) detalheDisplay.textContent = "0 dias x 0h por dia";
        jsonInput.value = "[]";
    }
}


function validateStep4() {
    esconderErro();
    
    const selectDias = document.getElementById('select_dias');
    const diasSelecionados = Array.from(selectDias.selectedOptions).length;
    const totalText = document.getElementById('total_horas').textContent;
    
    const match = totalText.match(/(\d+):/);
    const totalHours = match ? parseInt(match[1]) : 0;

    if (diasSelecionados === 0) {
        mostrarErro('Por favor, selecione ao menos um dia da semana.');
        return false;
    }

    const inputInicio = document.getElementById('hora_inicio_unico').value;
    const inputFim = document.getElementById('hora_fim_unico').value;
    if (!inputInicio || !inputFim) {
        mostrarErro('Por favor, preencha o horário de início e término.');
        return false;
    }

    if (totalHours > LIMITE_SEMANAL_HORAS) {
        mostrarErro(`A carga horária de ${totalHours}h excede o limite máximo de ${LIMITE_SEMANAL_HORAS}h semanais.`);
        return false;
    }

    return true;
}


let currentStep = 0;

function initNavigation() {
    const form = document.getElementById('termoForm');
    const fieldsets = form.querySelectorAll('fieldset');
    const steps = document.querySelectorAll('#stepsNav .step');
    const card = document.getElementById('content-area');

    function showStep(step) {
        if (step < 0 || step >= fieldsets.length) return;
        currentStep = step;

        fieldsets.forEach((fs, index) => {
            fs.style.display = (index === step) ? 'block' : 'none';
            fs.setAttribute('aria-hidden', (index !== step));
        });

        steps.forEach(s => s.classList.remove('active'));
        const activeStep = document.querySelector(`#stepsNav .step[data-step="${step}"]`);
        if (activeStep) activeStep.classList.add('active');

        if (card) {
            if (step === 0) {
                card.classList.remove('border-green-600');
                card.classList.add('border-red-500');
            } else {
                card.classList.remove('border-red-500');
                card.classList.add('border-green-600');
            }
        }
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    form.addEventListener('click', (e) => {
        const target = e.target;

        if (target.matches('[data-next]')) {
            e.preventDefault();
            if (currentStep === 4 && !validateStep4()) {
                return; 
            }
            if (currentStep < fieldsets.length - 1) {
                showStep(currentStep + 1);
            } else {
                form.submit();
            }
        }

        if (target.matches('[data-prev]')) {
            e.preventDefault();
            if (currentStep > 0) {
                showStep(currentStep - 1);
            }
        }
    });

    steps.forEach(s => {
        s.addEventListener('click', (e) => {
            e.preventDefault();
            const targetStep = parseInt(s.getAttribute('data-step'));
            if (targetStep > 4 && currentStep <= 4 && !validateStep4()) return;
            showStep(targetStep);
        });
    });

    showStep(0);
}


document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('termoForm')) {
        initNavigation();
    }

    const selectDias = document.getElementById('select_dias');
    const inputInicio = document.getElementById('hora_inicio_unico');
    const inputFim = document.getElementById('hora_fim_unico');

    if (selectDias) selectDias.addEventListener('change', calcularHorarios);
    if (inputInicio) inputInicio.addEventListener('input', calcularHorarios);
    if (inputFim) inputFim.addEventListener('input', calcularHorarios);

    const unidadeSelector = document.getElementById('unidade_tipo');
    if (unidadeSelector) {
        unidadeSelector.addEventListener('change', function() {
            const empresaFields = document.getElementById('campos-empresa');
            const autonomoFields = document.getElementById('campos-autonomo');
            
            if (this.value === 'empresa') {
                empresaFields?.classList.remove('hidden');
                autonomoFields?.classList.add('hidden');
            } else {
                empresaFields?.classList.add('hidden');
                autonomoFields?.classList.remove('hidden');
            }
        });
    }
});