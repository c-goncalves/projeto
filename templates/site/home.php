<?php
$page_title = "Início - Coordenação de Estágios";
?>

<section class="w-full bg-white py-6 px-8 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
  <div class="flex-1 text-center md:text-left">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Bem-vindo(a) ao Sistema de Gestão de Estágios (SGE)</h2>
    <p class="text-lg text-gray-600">Solicite e acompanhe a documentação do seu Estágio no IFSP Campus Guarulhos</p>
  </div>
  <div class="flex-shrink-0">
    <a href="<?= $routeParser->urlFor('solicitacao.index') ?>"
       class="inline-block bg-[#006633] text-white font-black px-10 py-4 rounded-lg hover:bg-[#004d26] transition-all shadow-lg hover:scale-105 uppercase tracking-wider">
       Iniciar Solicitação
    </a>
  </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 w-full">
    <div class="lg:col-span-2 space-y-6">
        <section class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-2xl font-bold text-[#006633] mb-6 flex items-center">
                <i class="fas fa-stream mr-3"></i> Estágio no IFSP
            </h3>

            <div class="flex flex-col gap-6">
                <a href="<?= $routeParser->urlFor('solicitacao.index') ?>" 
                   class="group block transition-all duration-300 shadow-sm hover:shadow-xl rounded-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 bg-white group-hover:bg-green-50/30 transition-colors"> 
                        <h4 class="font-bold text-[#006633] text-xl mb-3 flex items-center">
                            <span class="bg-green-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs mr-3">1</span>
                            Comece aqui
                        </h4>
                        <p class="text-gray-600 text-sm mb-4">
                            Preencha o Termo de Compromisso (TCE) e o Plano de Atividades. <strong>Só inicie o estágio após a assinatura de todas as partes!</strong>
                        </p>
                        <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-inner">
                            <h5 class="text-xs font-black text-gray-400 uppercase mb-3 tracking-widest text-center">Requisitos Principais</h5>
                            <div class="grid grid-cols-2 gap-4 text-xs text-gray-700">
                                <div class="flex items-center"><i class="fas fa-clock mr-2 text-green-600"></i> Máx. 6h diárias / 30h semanais</div>
                                <div class="flex items-center"><i class="fas fa-school mr-2 text-green-600"></i> Seguro contra acidentes</div>
                                <div class="flex items-center"><i class="fas fa-check-circle mr-2 text-green-600"></i> Empresa conveniada</div>
                                <div class="flex items-center"><i class="fas fa-user-tie mr-2 text-green-600"></i> Professor Orientador</div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="<?= $routeParser->urlFor('site.recursos') ?>" 
                   class="group block transition-all duration-300 shadow-sm hover:shadow-xl rounded-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 bg-white group-hover:bg-blue-50/30 transition-colors">
                        <h4 class="font-bold text-blue-800 text-xl mb-3 flex items-center">
                            <span class="bg-blue-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs mr-3">2</span>
                            Acompanhamento e Relatórios
                        </h4>
                        <p class="text-gray-600 text-sm">
                            Consulte os modelos de Relatórios Semestrais e Fichas de Acompanhamento. Lembre-se: o relatório deve ser enviado a cada 6 meses.
                        </p>
                    </div>
                </a>

                <a href="<?= $routeParser->urlFor('site.recursos') ?>" 
                   class="group block transition-all duration-300 shadow-sm hover:shadow-xl rounded-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 bg-white group-hover:bg-amber-50/30 transition-colors">
                        <h4 class="font-bold text-amber-800 text-xl mb-3 flex items-center">
                            <span class="bg-amber-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs mr-3">3</span>
                            Termos Aditivos
                        </h4>
                        <p class="text-gray-600 text-sm">
                            Mudou o horário? Prorrogou o contrato? Trocou de supervisor? Você precisa registrar um Termo Aditivo imediatamente.
                        </p>
                    </div>
                </a>
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <div class="bg-[#006633] p-6 rounded-2xl shadow-lg text-white">
            <h4 class="text-xl font-bold mb-4">Oportunidades</h4>
            <p class="text-sm text-green-100 mb-6">Confira as vagas de estágio abertas para o Câmpus Guarulhos.</p>
            <a href="https://gru.ifsp.edu.br/vagas" target="_blank" 
               class="block w-full bg-white text-[#006633] text-center font-bold py-3 rounded-lg hover:bg-green-50 transition-colors">
               Ver Vagas no Portal
            </a>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h4 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Links Rápidos</h4>
            <ul class="space-y-4">
                <li>
                    <a href="<?= $routeParser->urlFor('site.recursos') ?>" class="flex items-center text-sm text-gray-600 hover:text-[#006633] font-medium transition-colors">
                        <i class="fas fa-file-pdf mr-3 text-red-500"></i> Modelos de Documentos
                    </a>
                </li>
                <li>
                    <a href="<?= $routeParser->urlFor('site.recursos') ?>" class="flex items-center text-sm text-gray-600 hover:text-[#006633] font-medium transition-colors">
                        <i class="fas fa-gavel mr-3 text-gray-400"></i> Normas e Regulamentos
                    </a>
                </li>
                <li>
                    <a href="<?= $routeParser->urlFor('acompanhamento.index') ?>" class="flex items-center text-sm text-gray-600 hover:text-[#006633] font-medium transition-colors">
                        <i class="fas fa-search mr-3 text-blue-500"></i> Acompanhar Protocolo
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-300">
            <h4 class="text-sm font-bold text-gray-700 mb-2 uppercase tracking-tighter">Dúvidas?</h4>
            <p class="text-xs text-gray-500">Entre em contato com a CEX:</p>
            <a href="mailto:coord.estagios@ifsp.edu.br" class="text-sm font-bold text-[#006633] block mt-1 hover:underline">
                coord.estagios@ifsp.edu.br
            </a>
        </div>
    </aside>
</div>