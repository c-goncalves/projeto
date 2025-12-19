<div class="container-fluid py-4" style="background-color: #f1f3f5; min-height: 90vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            
            <div class="row flex justify-between items-center mb-4 bg-white py-3 px-4 rounded shadow-sm border-bottom border-success mx-0">
                    <a href="/" class="text-success text-decoration-none">Voltar </a>
                    <button onclick="window.print()" class="btn btn-success px-4 shadow-sm"><i class="fas fa-print me-2"></i>Imprimir Protocolo</button>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body text-center p-5">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-file-contract fa-2x text-success"></i>
                            </div>
                            <h4 class="fw-bold"><?= htmlspecialchars($dados['aluno_nome']) ?></h4>
                            <p class="text-muted small"><?= htmlspecialchars($dados['aluno_email']) ?></p>
                            
                            <hr>
                            
                            <label class="small text-uppercase fw-bold text-muted d-block mb-2">Status da Solicitação</label>
                            <?php 
                                $statusLabel = 'Em Análise';
                                $statusClass = 'bg-warning text-dark';
                                if (($dados['status_id'] ?? 1) == 2) { $statusLabel = 'Deferido'; $statusClass = 'bg-success'; }
                                if (($dados['status_id'] ?? 1) == 3) { $statusLabel = 'Indeferido'; $statusClass = 'bg-danger'; }
                            ?>
                            <div class="badge <?= $statusClass ?> fs-5 w-100 py-3 mb-3">
                                <?= $statusLabel ?>
                            </div>
                            
                            <p class="small text-muted italic">Última atualização: <?= date('d/m/Y H:i', strtotime($dados['created_at'])) ?></p>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white fw-bold">Chave de Segurança</div>
                        <div class="card-body">
                            <code class="text-break" style="font-size: 0.85rem;"><?= $dados['chave_acesso_aluno'] ?></code>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-success"></i>Informações da Solicitação</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-4 py-3" style="width: 30%;">Empresa</th>
                                        <td class="py-3"><?= htmlspecialchars($dados['empresa_razao_social']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4 py-3">CNPJ da Empresa</th>
                                        <td class="py-3"><?= htmlspecialchars($dados['empresa_cnpj'] ?? 'Não informado') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4 py-3">Tipo de Estágio</th>
                                        <td class="py-3"><?= ($dados['estagio_obrigatorio'] ?? true) ? 'Obrigatório' : 'Não Obrigatório' ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4 py-3">Data de Envio</th>
                                        <td class="py-3"><?= date('d/m/Y', strtotime($dados['created_at'])) ?> às <?= date('H:i', strtotime($dados['created_at'])) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php if (($dados['status_id'] ?? 1) == 1): ?>
                    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center p-4">
                        <i class="fas fa-clock fa-2x me-4"></i>
                        <div>
                            <h5 class="alert-heading fw-bold">Aguardando Avaliação</h5>
                            <p class="mb-0">Sua documentação foi recebida pela Coordenadoria de Extensão (CEX). O prazo médio de análise é de 5 dias úteis.</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="text-end mt-4">
                        <a href="/solicitacao/acompanhamento" class="btn btn-secondary px-4">Sair do Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>