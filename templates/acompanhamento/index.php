<div class="container-fluid py-5" style="background-color: #f8f9fa; min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-university me-2"></i> IFSP - Portal de Estágios</h5>
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-7 border-end">
                            <h2 class="text-2xl font-bold text-[#006633] mb-4">Acompanhar Solicitação</h2>
                            <p class="lead text-muted mb-4">Consulte o andamento do seu processo de estágio.</p>

                            <?php if (isset($_SESSION['erro_acompanhamento'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show me-lg-4">
                                    <?= $_SESSION['erro_acompanhamento']; unset($_SESSION['erro_acompanhamento']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                                
                            <form action="/acompanhamento/resultado" method="POST" class="bg-light p-4 rounded border me-lg-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-success">Protocolo</label>
                                    <input type="text" name="chave" class="form-control form-control-lg font-monospace" 
                                           placeholder="Ex: 00000000000000000000000000000000" required minlength="32" maxlength="32">
                                    <div class="form-text mt-2">O seu numero de protocolo foi enviada para o seu e-mail.</div>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-search me-2"></i>Consultar
                                </button>
                            </form>
                        </div>

                        <div class="col-lg-5 ps-lg-5 mt-5 mt-lg-0">
                            <h2 class="text-2xl font-bold text-gray-700 mb-4">Área Administrativa</h2>
                            <p class="text-muted mb-4">Acesso restrito para coordenadores e equipe CEX.</p>

                            <form action="/admin/login" method="POST" class="p-4 rounded border shadow-sm bg-white">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Login</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" name="usuario" class="form-control" placeholder="Ex: CP123456" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="senha" class="form-control" placeholder="******" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-outline-dark btn-lg w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Entrar
                                </button>
                            </form>
                            
                            <div class="mt-4 p-3 bg-yellow-50 rounded border border-yellow-200">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i> Esqueceu sua senha?.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>