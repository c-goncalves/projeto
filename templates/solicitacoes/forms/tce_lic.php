<?php

function print_tce($BASE_URL, $SERVER_URI, $curso, $old = [], $erro = null) {
    // Mapeamento de cursos para exibição no título
    switch ($curso) {
        case 'ads': $curso_nome = 'Tecnologia em Análise e Desenvolvimento de Sistemas'; break;
        case 'tai': $curso_nome = 'Tecnologia em Automação Industrial'; break;
        case 'eg':  $curso_nome = 'Engenharia de Computação'; break;
        case 'eca': $curso_nome = 'Engenharia de Controle e Automação'; break;
        case 'lic': $curso_nome = 'Licenciatura em Matemática'; break;
        default:    $curso_nome = 'Geral'; break;
    }
    ?>
    <div class="w-full mt-4">
        <section id="content-area" class="w-full bg-white p-8 rounded-xl shadow-lg border-t-8 border-green-600">
            <div class="mb-10 text-center border-b pb-6">
                <h3 class="text-[#006633] text-2xl font-black uppercase tracking-tight">
                    TCE: Termo de Compromisso de Estágio
                </h3>
                <p class="text-gray-500 font-bold mt-1"><?= $curso_nome ?></p>
            </div>

            <?php if ($erro): ?>
                <div class="p-4 mb-8 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm shadow-sm">
                    <div class="flex items-center mb-2">
                        <span class="mr-2">⚠️</span> <strong>Atenção: Verifique os campos abaixo</strong>
                    </div>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <?php foreach (explode('|', $erro) as $item): ?>
                            <li><?= htmlspecialchars(trim($item)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form id="termoForm" action="<?= $BASE_URL ?>solicitacao/processar" method="POST" class="space-y-12">
                <input type="hidden" name="doc_type" value="tce">
                <input type="hidden" name="estagiario[curso]" value="<?= $curso_nome ?>">

                <div class="space-y-6">
                    <h4 class="text-green-700 font-black border-b pb-2 flex items-center gap-3">
                        <span class="bg-green-700 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                        UNIDADE CONCEDENTE (EMPRESA)
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Razão Social *</label>
                            <input name="unidade_concedente[razao_social]" value="<?= htmlspecialchars($old['unidade_concedente']['razao_social'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">CNPJ (00.000.000/0000-00) *</label>
                            <input name="unidade_concedente[cnpj]" value="<?= htmlspecialchars($old['unidade_concedente']['cnpj'] ?? '') ?>" placeholder="00.000.000/0000-00" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Telefone *</label>
                            <input name="unidade_concedente[telefone]" value="<?= htmlspecialchars($old['unidade_concedente']['telefone'] ?? '') ?>" placeholder="(11) 2222-3333" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-200">
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-bold uppercase text-gray-400 italic">Endereço e Número *</label>
                                <input name="unidade_concedente[endereco][endereco]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['endereco'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-400 italic">CEP *</label>
                                <input name="unidade_concedente[endereco][cep]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['cep'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-400 italic">Bairro *</label>
                                <input name="unidade_concedente[endereco][bairro]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['bairro'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-400 italic">Cidade *</label>
                                <input name="unidade_concedente[endereco][cidade]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['cidade'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-400 italic">Estado (UF) *</label>
                                <input name="unidade_concedente[endereco][estado]" maxlength="2" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['estado'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t space-y-6">
                    <h4 class="text-green-700 font-black border-b pb-2 flex items-center gap-3">
                        <span class="bg-green-700 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                        SUPERVISOR DA EMPRESA
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Nome Completo do Supervisor *</label>
                            <input name="supervisor[nome]" value="<?= htmlspecialchars($old['supervisor']['nome'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">CPF do Supervisor *</label>
                            <input name="supervisor[cpf]" value="<?= htmlspecialchars($old['supervisor']['cpf'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Cargo *</label>
                            <input name="supervisor[cargo]" value="<?= htmlspecialchars($old['supervisor']['cargo'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t space-y-6">
                    <h4 class="text-green-700 font-black border-b pb-2 flex items-center gap-3">
                        <span class="bg-green-700 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span>
                        DADOS DO ESTAGIÁRIO
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Seu Nome Completo *</label>
                            <input name="estagiario[nome]" value="<?= htmlspecialchars($old['estagiario']['nome'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Prontuário (GU) *</label>
                            <input name="estagiario[prontuario]" value="<?= htmlspecialchars($old['estagiario']['prontuario'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">CPF *</label>
                            <input name="estagiario[cpf]" value="<?= htmlspecialchars($old['estagiario']['cpf'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">E-mail para Contato *</label>
                            <input name="estagiario[email]" type="email" value="<?= htmlspecialchars($old['estagiario']['email'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Celular *</label>
                            <input name="estagiario[celular]" value="<?= htmlspecialchars($old['estagiario']['celular'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm focus:border-green-500 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t space-y-6">
                    <h4 class="text-green-700 font-black border-b pb-2 flex items-center gap-3">
                        <span class="bg-green-700 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">4</span>
                        DATAS E SEGURO
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Data Início *</label>
                            <input name="dados_estagio[data_inicio]" type="date" value="<?= htmlspecialchars($old['dados_estagio']['data_inicio'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="text-[11px] font-black uppercase text-gray-400 tracking-wider">Data Término *</label>
                            <input name="dados_estagio[data_termino]" type="date" value="<?= htmlspecialchars($old['dados_estagio']['data_termino'] ?? '') ?>" required class="w-full border-2 border-gray-100 p-3 rounded-lg text-sm">
                        </div>
                        
                        <div class="md:col-span-2 bg-blue-50 p-6 rounded-xl border border-blue-100 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2 text-blue-800 font-black text-xs uppercase mb-2 tracking-widest">Informações da Apólice de Seguro</div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">Nome da Seguradora *</label>
                                <input name="dados_estagio[nome_seguradora]" value="<?= htmlspecialchars($old['dados_estagio']['nome_seguradora'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">Número da Apólice *</label>
                                <input name="dados_estagio[numero_apolice_seguro]" value="<?= htmlspecialchars($old['dados_estagio']['numero_apolice_seguro'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center pt-10">
                    <button type="submit" class="w-full md:w-2/3 bg-[#006633] text-white font-black py-5 rounded-2xl shadow-2xl hover:bg-green-700 transition-all hover:scale-105 uppercase tracking-widest text-lg">
                        Validar Informações e Gerar PDF
                    </button>
                    <p class="text-xs text-gray-400 mt-4 italic">Ao clicar, o sistema validará os dados e abrirá o documento para impressão.</p>
                </div>
            </form>
        </section>
    </div>
<?php } ?>