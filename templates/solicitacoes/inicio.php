

<section class="intro  mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold text-[#006633] mb-4">Antes de Iniciar o Estágio</h2>
  <p class="text-gray-700 mb-2">Confira abaixo os passos, documentos e orientações essenciais antes de iniciar seu estágio.</p>
  <p class="text-gray-700 mb-4">Caso tenha dúvidas, entre em contato com a Coordenação de Estágios pelo e-mail <a href="mailto:coord.estagios@ifsp.edu.br" class="text-[#006633] underline">coord.estagios@ifsp.edu.br</a></p>

  <section class="info-geral bg-white border-l-4 border-[#006633] p-4 rounded shadow mb-6">
    <h3 class="text-lg font-semibold mb-2">Informações gerais</h3>
    <ul class="list-none space-y-1 text-gray-700">
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-0.5">➤</span>
        Preencha o formulario abaixo.
      </li>
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-0.5">➤</span>
        Baixe o Termo de Compromisso com os seus dados preenchidos e recolha as assinaturas da unidade concedente.
      </li>
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-0.5">➤</span>
        Acesse o acompanhamento do processo, anexe os documentos assinados e envie para analise.
      </li>
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-1">➤</span>
        Prazo de análise: até 5 dias úteis após envio completo.
      </li>
    <li class="flex items-start gap-2">
      <span class="text-[#006633] mt-0.5">➤</span>
      Aguarde a devolutiva do Instituto para iniciar o seu estágio.
    </li>
    <li class="flex items-start gap-2">
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-1">➤</span>
        A CEX não assina documentos com data retroativa.
      </li>
      <li class="flex items-start gap-2">
        <span class="text-[#006633] mt-1">➤</span>
        O estágio não pode ser iniciado sem assinatura de todas as partes.
      </li>
      
      </li>
    </ul>
</section>




<section class="bg-gray-50 p-6 rounded-xl shadow-md border-l-4 border-[#78BE20] mb-6">
    <div class="flex items-center space-x-4">
        <div class="bg-[#78BE20] p-3 rounded-full text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-bold text-gray-800">Preencha o formulario:</h3>
            <p class="text-sm text-gray-600">Inicie o processo gerando o seu Termo de Compromisso</p>
        </div>
    </div>
    <div class="mt-4">
        <select id="cursoSelect" class="block w-full p-3 border-2 border-[#006633] rounded-lg bg-white text-gray-800 font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-[#78BE20] focus:border-[#78BE20] transition-all">
        <option value="">Selecione seu curso</option>
        <option value="lic">Licenciatura em Matemática</option>
        <option value="ads">Tecnologia em Análise e Desenvolvimento de Sistemas</option>
        <option value="tai">Tecnologia em Automação Industrial</option>
        <option value="eg">Engenharia de Computação</option>
        <option value="eca">Engenharia de Controle e Automação</option>
        <option value="tce">Outros / Estágio Não Obrigatório</option>
    </select>
    </div>
</section>

<section class="bg-gray-50 p-6 rounded-xl shadow-md border-l-4 border-[#78BE20]">
    <div class="flex items-center space-x-4">
        <div class="bg-[#78BE20] p-3 rounded-full text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-bold text-gray-800">Já possui o documento assinado?</h3>
            <p class="text-sm text-gray-600">Se você já preencheu o formulário e coletou as assinaturas, envie o Documento aqui para análise.</p>
        </div>
    </div>
    <div class="mt-4">
        <a href="<?= $routeParser->urlFor('solicitacao.enviar') ?>" class="inline-block px-6 py-2 bg-[#006633] text-white font-bold rounded-lg hover:bg-[#004d26] transition shadow-md">
            Ir para Envio de Arquivos
        </a>
    </div>
</section>


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
  document.getElementById('cursoSelect').addEventListener('change', function() {
    const curso = this.value;
    if (!curso) return;

    <?php 
    $urlTce = "#";
    if (isset($routeParser)) {
        try {
            $urlTce = $routeParser->urlFor('solicitacao.tce', ['tipo' => 'obrigatorio']);
        } catch (\Exception $e) {
            $urlTce = $BASE_URL . "solicitacao/tce/obrigatorio";
        }
    }
    ?>

    const baseUrl = "<?= $urlTce ?>";
    if (baseUrl === "#") return;

    if (curso === 'tce') {
        window.location.href = baseUrl;
    } else {
        window.location.href = baseUrl + '?curso=' + curso;
    }
});
</script>
