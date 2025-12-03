<?php
$page_title = "Início - Coordenação de Estágios";


?>

<section class="bg-white py-1 px-6 rounded-xl  flex flex-col md:flex-row items-start justify-between gap-4">
  <div class="flex-1">
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Bem-vindo(a) ao Sistema de Gestão de Estágios (SGE)</h2>
    <p class="text-gray-700">Solicite e acompanhe a documentação do seu Estágio Obrigatório dos cursos da IFSP Campus Guarulhos</p>
  </div>
  <div class="flex-shrink-0">
    <a href="solicitacao/"
       class="inline-block bg-[#006633] text-white font-bold px-6 py-2 rounded hover:bg-[#004d26] transition-colors">
       Iniciar Solicitação
    </a>
  </div>
</section>

<section class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md shadow-[0_0_15px_rgba(0,0,0,0.1)]" id="content-area">
    <h3 class="text-xl font-bold text-[#006633] mb-4">Estágio Curricular no IFSP</h3>

    <p class="text-gray-700 text-sm mb-6">
        Aqui você encontra o passo a passo completo do estágio, do início ao encerramento. Seguindo as etapas abaixo, você garante que todos os requisitos sejam cumpridos e que o processo seja finalizado sem problemas.
    </p>

    <div class="flex flex-col gap-6 ">

        <a href="solicitacao" 
           class="block transition-all duration-300 ease-in-out shadow-md rounded-lg hover:shadow-xl hover:-translate-y-1">
            
            <div class="p-4 rounded-lg"> 
                <h4 class="font-semibold text-[#09332a] text-lg mb-3">
                    Início:
                </h4>
                
                <p class="text-sm text-gray-700 mb-3">
                    Preencha o Termo de Compromisso de Estágio (TCE) e o Plano de Atividades para aprovação. Só inicie suas atividades após a aprovação e assinatura do TCE!
                </p>

                <h5 class="text-[#004d26] font-bold text-sm mb-2">O que você precisa saber:</h5>
                <ul class="list-disc pl-6 space-y-2 text-gray-800 text-sm">
                  <li><strong>Total de horas:</strong> 400 horas, divididas em 4 etapas de 100 horas cada.</li>
                  <li><strong>Local:</strong> Livre, menos para as licenciaturas que devem ser feitas na escolas de educação básica.</li>
                  <li><strong>Início:</strong> Pode começar já no 1º semestre do curso.</li>
                  <li><strong>Orientação:</strong> Um professor orientador irá acompanhar cada etapa. Não se perca!</li>
                  <li><strong>Início do seu estágio:</strong> O Termo de Compromisso de Estágio (TCE) devem ser aprovados antes de começar.</li>
                  
                </ul>
            </div>
        </a>

        <a href="documentos" class=" text-[#09332a] hover:no-underline block mb-1 text-lg">
        <div class="transition-all duration-300 ease-in-out shadow-md rounded-lg hover:shadow-xl hover:-translate-y-1">
                <div class=" p-4 rounded-lg">
                    <h4 class="font-semibold text-[#09332a] hover:no-underline block mb-1 text-lg">
                        Acompanhamento e Entrega de Relatórios
                    </h4>
                    <p class="text-sm text-gray-700">
                      Você deverá preencher a Ficha de Acompanhamento, entregar o Certificado Individual de Seguro e preencher os relatórios periódicos no sistema SUAP. Em caso de alterações, é necessário preencher um Termo Aditivo.
                    </p>
                </div>
              </div>
            </a>

            <a href="aditivos" class="text-[#09332a] hover:no-underline block mb-1 text-lg">
        <div class="transition-all duration-300 ease-in-out shadow-md rounded-lg hover:shadow-xl hover:-translate-y-1">
                <div class="p-4 rounded-lg">
                    <h4 class="font-semibold text-[#09332a] hover:no-underline block mb-1 text-lg">
                        Termos Aditivos e Mudanças de Contrato
                    </h4>
                    <p class="text-sm text-gray-700">
                        Em caso de mudança na carga horária, atividades ou vigência, é obrigatório preencher um Termo Aditivo. Registre qualquer alteração para manter a validade legal do seu estágio.
                    </p>
                </div>
              </div>
            </a>

            <a href="encerramento" class=" text-[#09332a] hover:no-underline block mb-1 text-lg">
        <div class="transition-all duration-300 ease-in-out shadow-md rounded-lg hover:shadow-xl hover:-translate-y-1">
                <div class="p-4 rounded-lg">
                    <h4 class="font-semibold text-[#09332a] hover:no-underline block mb-1 text-lg">
                        Encerramento do Estágio
                    </h4>
                    <p class="text-sm text-gray-700">
                      Já no final do seu estágio você deverá entregar o Certificado Individual de Seguro, os relatórios mensais ou semestrais e garantir que todas as telas do SUAP estejam preenchidas.
                    </p>
                </div>
            </a>
        </div>
    </div>
</section>




<aside class="bg-white p-6 shadow-md border-l-4 border-[#006633] rounded hidden md:block">  
  <div class="mb-4 p-3 bg-green-100 ">
    <a href="https://gru.ifsp.edu.br/vagas" target="_blank" 
       class="text-[#006633] font-semibold hover:no-underline">
      Oportunidades de estágio
    </a>
  </div>

  <h4 class="text-[#006633] font-semibold mb-3 bg-green-100 p-3"><a href="recursos" >Recursos e Documentos</a></h4>

  <ul class="space-y-2 px-4">
    <li><a href="#" class="text-sm text-gray-700 hover:no-underline">Modelos de Documentos</a></li>
    <li><a href="#" class="text-sm text-gray-700 hover:no-underline">Normas e Regulamentos</a></li>
    <li><a href="#" class="text-sm text-gray-700 hover:no-underline">Dúvidas Frequentes</a></li>
  </ul>

  <div class="mt-4">
    <a href="/pages/recursos/" class="text-[#006633] font-semibold hover:no-underline">
      + Recursos
    </a>
  </div>
</aside>

