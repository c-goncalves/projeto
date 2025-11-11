<section class="intro  mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold text-[#006633] mb-4">Antes de Iniciar o Estágio</h2>
  <p class="text-gray-700 mb-2">Confira abaixo os passos, documentos e orientações essenciais antes de iniciar seu estágio.</p>
  <p class="text-gray-700 mb-4">Caso tenha dúvidas, entre em contato com a Coordenação de Estágios pelo e-mail <a href="mailto:coord.estagios@ifsp.edu.br" class="text-[#006633] underline">coord.estagios@ifsp.edu.br</a></p>

  <section class="info-geral bg-white border-l-4 border-[#006633] p-4 rounded shadow mb-6">
    <h3 class="text-lg font-semibold mb-2">Informações gerais</h3>
    <ul class="list-none space-y-1 text-gray-700">
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-0.5">➤</span>
        Prazo de análise: até 5 dias úteis após envio completo.
      </li>
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-0.5">➤</span>
        A CEX não assina documentos com data retroativa.
      </li>
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-0.5">➤</span>
        O estágio não pode ser iniciado sem assinatura de todas as partes.
      </li>
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-0.5">➤</span>
        Mantenha-se informado: 
        <a href="<?php echo PAGES_PATH; ?>recursos/" class="text-[#007a4d] underline <?php echo strpos($current_uri, '/pages/recursos/') !== false ? 'font-bold' : ''; ?>">
          Recursos
        </a>
      </li>
    </ul>
</section>


  <h3 class="text-lg font-semibold mb-2">Selecione o seu curso:</h3>
    <select id="cursoSelect" class="block w-full p-3 border-2 border-[#006633] rounded-lg bg-white text-gray-800 font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-[#78BE20] focus:border-[#78BE20] transition-all">
      <option value="">Selecione seu curso</option>
      <option value="matematica">Licenciatura em Matemática</option>
      <option value="ads">Tecnologia em Análise e Desenvolvimento de Sistemas</option>
      <option value="automacao">Tecnologia em Automação Industrial</option>
      <option value="engenharia_computacao">Engenharia de Computação</option>
      <option value="engenharia_controle">Engenharia de Controle e Automação</option>
      <option value="nao_obrigatorio">Estágio Não Obrigatório</option>
    </select>

  <div id="informacoesCurso" class="mt-4"></div>
</section>


<!-- Modal -->
<div id="cursoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
  <div class="bg-white rounded-xl p-8 w-11/12 max-w-lg relative shadow-2xl">
    <button class="absolute top-3 right-4 text-3xl font-bold text-gray-600 hover:text-[#006633] close">&times;</button>
    <div id="modalBody" class="space-y-4 text-gray-700"></div>
  </div>
</div>



<style>
.modal {
  display: none; 
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  display: flex;
}


.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 600px;
  position: relative;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 24px;
  cursor: pointer;
}
</style>

<script>
const cursosInfo = {
    matematica: `
    <h3 class="text-xl font-bold text-[#006633] mb-3">Licenciatura em Matemática</h3>
    <ul class="list-disc list-inside space-y-2">
      <li>Termo de Compromisso específico para licenciaturas.</li>
      <li>Plano de Atividades específico para licenciaturas.</li>
      <li>Documentos obrigatórios:
        <ul class="list-decimal list-inside ml-5 mt-1 space-y-1">
          <li><a href="https://gru.ifsp.edu.br/images/CEX/TermoDeCompromissoLicenciaturasEstagioObrigatorio_Abril2025.docx" target="_blank" class="text-[#007a4d] underline hover:text-[#004d26]">Termo de Compromisso (docx)</a></li>
          <li><a href="https://gru.ifsp.edu.br/images/CEX/AnexoIV-PlanoDeAtividadesDoEstagiario_MAT_1.doc" target="_blank" class="text-[#007a4d] underline hover:text-[#004d26]">Plano de Atividades do Estagiário (docx)</a></li>
        </ul>
      </li>
    </ul>
    <a href="<?php echo BASE_URL; ?>solicitacoes/licenciatura/form/2" class="inline-block mt-4 px-5 py-2 bg-[#006633] text-white font-semibold rounded-lg hover:bg-[#004d26] transition">Iniciar Solicitação</a>
  `,
  ads: `
    <h3>Tecnologia em Análise e Desenvolvimento de Sistemas</h3>
    <ul>
      <li>Documentos obrigatórios: Termo de Compromisso e Plano de Atividades padrão.</li>
      <li>Prazo de análise: até 5 dias úteis.</li>
    </ul>
    <a href="<?php echo BASE_URL; ?>solicitacoes/ads/form/2" class="btn" style="margin-top:10px; display:inline-block;">Iniciar Solicitação</a>
  `,
  automacao: `
    <h3>Tecnologia em Automação Industrial</h3>
    <ul>
      <li>Documentos obrigatórios: Termo de Compromisso e Plano de Atividades padrão.</li>
      <li>É necessário apresentar plano de atividades detalhado com supervisão da empresa.</li>
    </ul>
    <a href="<?php echo BASE_URL; ?>solicitacoes/automacao/form/2" class="btn" style="margin-top:10px; display:inline-block;">Iniciar Solicitação</a>
  `,
  engenharia_computacao: `
    <h3>Engenharia de Computação</h3>
    <ul>
      <li>Termo de Compromisso e Plano de Atividades padrão.</li>
      <li>Coordenação recomenda envio de cronograma de atividades antes do início do estágio.</li>
    </ul>
    <a href="<?php echo BASE_URL; ?>solicitacoes/engenharia_computacao/form/2" class="btn" style="margin-top:10px; display:inline-block;">Iniciar Solicitação</a>
  `,
  engenharia_controle: `
    <h3>Engenharia de Controle e Automação</h3>
    <ul>
      <li>Termo de Compromisso e Plano de Atividades padrão.</li>
      <li>Documentação deve ser assinada pela empresa e aluno antes do início do estágio.</li>
    </ul>
    <a href="<?php echo BASE_URL; ?>solicitacoes/engenharia_controle/form/2" class="btn" style="margin-top:10px; display:inline-block;">Iniciar Solicitação</a>
  `,
  nao_obrigatorio: `
    <h3>Estágio Não Obrigatório (Pago)</h3>
    <ul>
      <li>Estágio remunerado, opcional para o aluno.</li>
      <li>Documentos obrigatórios:
        <ul>
          <li><a href="https://gru.ifsp.edu.br/images/CEX/AnexoI-TermoDeCompromissoDeEstagioNaoObrigatorio_Abril2025.docx" target="_blank">Termo de Compromisso</a></li>
        </ul>
      </li>
      <li>Plano de Atividades deve ser enviado e aprovado antes do início.</li>
    </ul>
    <a href="<?php echo BASE_URL; ?>solicitacoes/nao_obrigatorio/form/2" class="btn" style="margin-top:10px; display:inline-block;">Iniciar Solicitação</a>
  `
};



const select = document.getElementById('cursoSelect');
const modal = document.getElementById('cursoModal');
const modalBody = document.getElementById('modalBody');
const closeBtn = document.querySelector('.modal .close');
select.addEventListener('change', () => {
  const valor = select.value;
  if (valor && cursosInfo[valor]) {
    modalBody.innerHTML = cursosInfo[valor];
    modal.style.display = 'flex'; 
  }
});

closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
  if (e.target === modal) {
    modal.style.display = 'none';
  }
});

</script>
