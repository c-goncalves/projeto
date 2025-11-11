<?php
$page_title = "Início - Coordenação de Estágios";
require_once BASE_PATH . '/includes/header.php';
?>

<section class="bg-white py-1 px-6 rounded-xl  flex flex-col md:flex-row items-start justify-between gap-4">
  <div class="flex-1">
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Bem-vindo(a) ao Sistema de Gestão de Estágios (SGE)</h2>
    <p class="text-gray-700">Solicite e acompanhe a documentação do seu Estágio Obrigatório dos cursos da IFSP Campus Guarulhos</p>
  </div>
  <div class="flex-shrink-0">
    <a href="<?php echo BASE_URL; ?>solicitacoes/"
       class="inline-block bg-[#006633] text-white font-bold px-6 py-2 rounded hover:bg-[#004d26] transition-colors">
       Iniciar Solicitação
    </a>
  </div>
</section>

<div class="mt-2 grid grid-cols-1 lg:grid-cols-3 gap-6">
  <!-- Conteúdo principal -->
  <section class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md border-l-4 border-[#006633] bg-green-50" id="content-area">
  <h3 class="text-xl font-bold text-[#006633] mb-4">Estágio no IF</h3>

  <!-- Info Box estilo "chamada do grêmio" -->
<div class="border-l-8 border-[#006633] p-4 rounded mb-6 shadow-sm">
<h4 class="text-[#004d26] font-semibold mb-3 text-lg">O que você precisa saber:</h4>
<ul class="list-disc pl-6 space-y-2 text-gray-800 text-sm">
<li><strong>Total de horas:</strong> 400 horas, divididas em 4 etapas de 100 horas cada.</li>
<li><strong>Local:</strong> Livre, menos para as licenciaturas que devem ser feitas na escolas de educação básica.</li>
<li><strong>Início:</strong> Pode começar já no 1º semestre do curso.</li>
<li><strong>Orientação:</strong> Um professor orientador irá acompanhar cada etapa. Não se perca!</li>
<li><strong>Início do seu estágio:</strong> O Termo de Compromisso de Estágio (TCE) e o Plano de Atividades de Estágio devem ser aprovados antes de começar.</li>
<li><strong>Durante:</strong> Você deverá preencher a Ficha de Acompanhamento, entregar o Certificado Individual de Seguro e preencher os relatórios periódicos no sistema SUAP. Em caso de alterações, é necessário preencher um Termo Aditivo.</li>
<li><strong>Final:</strong> Já no final do seu estágio você deverá entregar o Certificado Individual de Seguro, os relatórios mensais ou semestrais e garantir que todas as telas do SUAP estejam preenchidas.</li>
<li><strong>Relatórios:</strong> Devem ser entregues a cada etapa, assinados por você e seu supervisor, e enviados em PDF ao seu orientador para posterior anexo no sistema SUAP. Fique em dia!</li>
</ul>
</div>

  <p class="text-gray-700 text-sm mb-4">
    Aqui você encontra o passo a passo do estágio: do início até o encerramento. Seguindo essas etapas, você garante que tudo seja feito certinho e sem dores de cabeça!
  </p>

  <hr class="my-5 border-gray-300">

  <h4 class="text-[#006633] font-semibold mb-3">📋 Etapas do Estágio:</h4>

  <div class="flex flex-col gap-4">
    <div class="border-l-4 border-[#006633] bg-green-50 p-4 rounded">
      <a href="<?php echo BASE_URL; ?>solicitacoes"
         class="font-semibold text-[#09332a] hover:underline block mb-1">
        🚀 Início do Estágio
      </a>
      <p class="text-sm text-gray-700">Preencha o TCE e envie para aprovação. Só depois comece suas atividades!</p>
    </div>
    <div class="border-l-4 border-[#006633] bg-green-50 p-4 rounded">
      <a href="<?php echo BASE_URL; ?>documentos"
         class="font-semibold text-[#09332a] hover:underline block mb-1">
        📌 Acompanhamento
      </a>
      <p class="text-sm text-gray-700">Registre suas atividades, entregue relatórios periódicos e mantenha contato com seu orientador.</p>
    </div>
    <div class="border-l-4 border-[#006633] bg-green-50 p-4 rounded">
      <a href="<?php echo BASE_URL; ?>aditivos"
         class="font-semibold text-[#09332a] hover:underline block mb-1">
        ✏️ Termos Aditivos
      </a>
      <p class="text-sm text-gray-700">Se mudar algo na carga horária ou atividades, registre os aditivos para não ter problemas depois.</p>
    </div>
    <div class="border-l-4 border-[#006633] bg-green-50 p-4 rounded">
      <a href="<?php echo BASE_URL; ?>encerramento"
         class="font-semibold text-[#09332a] hover:underline block mb-1">
        🏁 Encerramento
      </a>
      <p class="text-sm text-gray-700">Finalize com o relatório, obtenha avaliação do orientador e confirme que todos os documentos foram entregues.</p>
    </div>
  </div>
</section>



  <!-- Sidebar / Recursos -->
<aside class="bg-white p-6 shadow-md border-l-4 border-[#006633] rounded">
  
  <!-- Destaque: Oportunidades de Estágio -->
  <div class="mb-4 p-3 bg-green-100 ">
    <a href="https://gru.ifsp.edu.br/vagas" target="_blank" 
       class="text-[#006633] font-semibold hover:underline">
      Oportunidades de estágio
    </a>
  </div>

  <!-- Título do menu -->
  <h4 class="text-[#006633] font-semibold mb-3 bg-green-100 p-3"><a href="<?php echo BASE_URL; ?>recursos" >Recursos e Documentos</a></h4>

  <!-- Lista de recursos -->
  <ul class="space-y-2 px-4">
    <li><a href="#<?php echo BASE_URL; ?>" class="text-sm text-gray-700 hover:underline">Modelos de Documentos</a></li>
    <li><a href="#<?php echo BASE_URL; ?>" class="text-sm text-gray-700 hover:underline">Normas e Regulamentos</a></li>
    <li><a href="#<?php echo BASE_URL;?>" class="text-sm text-gray-700 hover:underline">Dúvidas Frequentes</a></li>
  </ul>

  <!-- Link + Recursos -->
  <div class="mt-4">
    <a href="<?php echo BASE_URL; ?>/pages/recursos/" class="text-[#006633] font-semibold hover:underline">
      + Recursos
    </a>
  </div>
</aside>


<?php 
require_once BASE_PATH . '/includes/footer.php';
?>
