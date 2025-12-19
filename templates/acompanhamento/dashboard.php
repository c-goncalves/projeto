<div class="w-full py-8 px-6" style="background-color: #f1f3f5; min-height: 90vh;">
    
    <div class="w-full flex justify-between items-center mb-6 bg-white py-4 px-6 rounded-xl shadow-sm border-b-4 border-[#006633]">
        <a href="/acompanhamento" class="text-[#006633] font-bold hover:underline flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Voltar para Consulta
        </a>
        <button onclick="window.print()" class="bg-[#006633] text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-green-700 transition-all flex items-center">
            <i class="fas fa-print mr-2"></i> Imprimir Protocolo
        </button>
    </div>

    <div class="w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gray-800 text-white py-4 px-8">
            <h3 class="text-xl font-bold flex items-center">
                <i class="fas fa-file-invoice mr-3"></i> Detalhes da Solicitação de Estágio
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase">Aluno</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase">Prontuário</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase">Protocolo (Chave)</th>
                        <th class="px-8 py-5 text-sm font-bold text-gray-600 uppercase text-center">Status Atual</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="font-bold text-lg text-gray-900"><?= htmlspecialchars($dados['aluno_nome']) ?></div>
                            <div class="text-sm text-gray-500"><?= htmlspecialchars($dados['aluno_email']) ?></div>
                        </td>
                        
                        <td class="px-8 py-6 text-gray-700 font-medium">
                            <?= htmlspecialchars($dados['aluno_prontuario'] ?? 'Não informado') ?>
                        </td>
                        
                        <td class="px-8 py-6">
                            <code class="bg-gray-100 p-2 rounded text-[#006633] font-mono text-sm break-all">
                                <?= $dados['chave_acesso_aluno'] ?>
                            </code>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <?php 
                                $statusLabel = 'Em Análise';
                                $statusClass = 'bg-amber-100 text-amber-800 border-amber-200';
                                if (($dados['status_id'] ?? 1) == 2) { 
                                    $statusLabel = 'Deferido'; 
                                    $statusClass = 'bg-green-100 text-green-800 border-green-200'; 
                                }
                                if (($dados['status_id'] ?? 1) == 3) { 
                                    $statusLabel = 'Indeferido'; 
                                    $statusClass = 'bg-red-100 text-red-800 border-red-200'; 
                                }
                            ?>
                            <span class="px-6 py-2 rounded-full font-black uppercase text-xs border <?= $statusClass ?>">
                                <?= $statusLabel ?>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-8 py-4 flex justify-between items-center text-xs text-gray-500 border-t">
            <span><strong>Data de Envio:</strong> <?= date('d/m/Y H:i', strtotime($dados['created_at'])) ?></span>
            <span><strong>Última Atualização:</strong> <?= date('d/m/Y H:i', strtotime($dados['created_at'])) ?></span>
        </div>
    </div>

    <?php if (($dados['status_id'] ?? 1) == 1): ?>
    <div class="w-full mt-6 bg-blue-50 border-l-8 border-blue-500 p-6 rounded-xl shadow-sm flex items-center">
        <div class="text-3xl mr-6">🕒</div>
        <div>
            <h4 class="text-blue-900 font-bold text-lg">Aguardando Avaliação pela CEX</h4>
            <p class="text-blue-800">Sua documentação já está na fila de análise da Coordenadoria de Extensão. O prazo médio de retorno é de 5 dias úteis.</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="mt-8 text-center">
        <a href="/acompanhamento" class="text-gray-500 hover:text-gray-800 font-medium">
            <i class="fas fa-sign-out-alt mr-1"></i> Sair do Painel de Consulta
        </a>
    </div>
</div>