<div class="w-full py-12 px-6" style="background-color: #f8f9fa; min-height: 80vh;">
    <div class="w-full">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border-0">
            
            

            <div class="p-8 lg:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    
                    <div class="lg:col-span-7 lg:border-r lg:border-gray-100 lg:pr-12">
                        <div class="mb-8">
                            <h2 class="text-3xl font-extrabold text-[#006633] mb-4">Acompanhar Solicitação</h2>
                            <p class="text-lg text-gray-600">Consulte o andamento do seu processo de estágio em tempo real.</p>
                        </div>

                        <?php if (isset($_SESSION['erro_acompanhamento'])): ?>
                            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center">
                                <div><?= $_SESSION['erro_acompanhamento']; unset($_SESSION['erro_acompanhamento']); ?></div>
                                <button type="button" class="text-red-500 font-bold" onclick="this.parentElement.remove()">×</button>
                            </div>
                        <?php endif; ?>
                            
                        <form action="/acompanhamento/resultado" method="POST" class="bg-gray-50 p-8 rounded-2xl border border-gray-200">
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-[#006633] uppercase tracking-wider mb-2">Código de Protocolo</label>
                                <input type="text" name="chave" 
                                       class="w-full p-4 text-lg border-2 border-gray-200 rounded-xl focus:border-[#006633] focus:ring-0 transition-all font-mono shadow-inner" 
                                       placeholder="Digite os 32 caracteres do seu protocolo" 
                                       required minlength="32" maxlength="32">
                                <p class="text-xs text-gray-500 mt-3 flex items-center italic">
                                    <i class="fas fa-info-circle mr-2"></i> O número do protocolo foi enviado para o seu e-mail no ato da solicitação.
                                </p>
                            </div>
                            <button type="submit" class="w-full bg-[#006633] text-white py-4 rounded-xl font-bold text-lg hover:bg-green-700 transition-all shadow-lg hover:shadow-green-200 uppercase tracking-widest">
                                <i class="fas fa-search mr-2"></i> Consultar Status
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-5 flex flex-col justify-center">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold text-gray-700 mb-4">Área Administrativa</h2>
                            <p class="text-gray-500">Acesso exclusivo para Coordenadores de curso e equipe CEX.</p>
                        </div>

                        <form action="/admin/login" method="POST" class="p-8 rounded-2xl border border-gray-100 bg-white shadow-sm">
                            <div class="mb-5">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Prontuário / Usuário</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" name="usuario" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 outline-none transition-all" placeholder="Ex: CP123456" required>
                                </div>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Senha</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" name="senha" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 outline-none transition-all" placeholder="******" required>
                                </div>
                            </div>
                            <button type="submit" class="w-full py-3 border-2 border-gray-800 text-gray-800 font-bold rounded-lg hover:bg-gray-800 hover:text-white transition-all uppercase text-sm tracking-widest">
                                <i class="fas fa-sign-in-alt mr-2"></i> Acessar Sistema
                            </button>
                        </form>
                        
                        <div class="mt-6 p-4 bg-amber-50 rounded-xl border border-amber-100 text-center">
                            <a href="#" class="text-amber-800 text-xs font-semibold hover:underline">
                                <i class="fas fa-question-circle mr-1"></i> Esqueceu sua senha? Solicite recuperação via suporte.
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>