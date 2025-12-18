

   <?php
function print_tce($BASE_URL, $SERVER_URI, $curso, $old = [], $erro = null) {
    switch ($curso){
        case 'ads': $curso = 'Tecnologia em Análise e Desenvolvimento de Sistemas'; break;
        case 'tai': $curso = 'Tecnologia em Automação Industrial'; break;
        case 'eg':  $curso = 'Engenharia de Computação'; break;
        case 'eca': $curso = 'Engenharia de Controle e Automação'; break;
        default:    $curso = 'Geral'; break;
    }
    ?>
    <div class="w-full mt-4">
        <section id="content-area" class="w-full bg-white p-8 rounded-xl shadow-lg border-t-4 border-green-600">
            <h3 class="text-green-800 text-xl font-bold mb-6 text-center">
                TCE: Termo de Compromisso de Estágio<br>
                <span class="text-sm text-gray-500 uppercase"><?= $curso_nome ?></span>
            </h3>

            <?php if ($erro): ?>
                <div class="p-4 mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                    <strong>Erros:</strong>
                    <ul class="list-disc list-inside mt-2">
                        <?php foreach (explode('|', $erro) as $item): ?>
                            <li><?= htmlspecialchars(trim($item)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form id="termoForm" action="<?= $BASE_URL ?>solicitacao/enviar" method="POST" class="space-y-10">
                <input type="hidden" name="doc_type" value="tce">
                <input type="hidden" name="estagiario[curso]" value="<?= $curso_nome ?>">

                <div class="space-y-4">
                    <h4 class="text-green-700 font-bold border-b pb-2 flex items-center gap-2">
                        <span class="bg-green-700 text-white w-5 h-5 rounded-full flex items-center justify-center text-xs">1</span>
                        Unidade Concedente
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold uppercase text-gray-500">Razão Social *</label>
                            <input name="unidade_concedente[razao_social]" value="<?= htmlspecialchars($old['unidade_concedente']['razao_social'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">CNPJ (XX.XXX.XXX/XXXX-XX)</label>
                            <input name="unidade_concedente[cnpj]" value="<?= htmlspecialchars($old['unidade_concedente']['cnpj'] ?? '') ?>" placeholder="00.000.000/0000-00" class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Telefone * (XX) XXXX-XXXX</label>
                            <input name="unidade_concedente[telefone]" value="<?= htmlspecialchars($old['unidade_concedente']['telefone'] ?? '') ?>" placeholder="(11) 2222-3333" required class="w-full border p-2 rounded text-sm">
                        </div>
                        
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded border border-dashed">
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-bold uppercase text-gray-400">Logradouro e Nº *</label>
                                <input name="unidade_concedente[endereco][endereco]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['endereco'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-400">CEP * (XXXXX-XXX)</label>
                                <input name="unidade_concedente[endereco][cep]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['cep'] ?? '') ?>" placeholder="01001-000" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-400">Bairro *</label>
                                <input name="unidade_concedente[endereco][bairro]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['bairro'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-400">Cidade *</label>
                                <input name="unidade_concedente[endereco][cidade]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['cidade'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-400">Estado (Sigla) *</label>
                                <input name="unidade_concedente[endereco][estado]" value="<?= htmlspecialchars($old['unidade_concedente']['endereco']['estado'] ?? '') ?>" maxlength="2" placeholder="SP" required class="w-full border p-2 rounded text-sm bg-white">
                            </div>
                        </div>

                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">Representante Legal *</label>
                                <input name="unidade_concedente[representante_legal][nome]" value="<?= htmlspecialchars($old['unidade_concedente']['representante_legal']['nome'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">Cargo Representante *</label>
                                <input name="unidade_concedente[representante_legal][cargo]" value="<?= htmlspecialchars($old['unidade_concedente']['representante_legal']['cargo'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t space-y-4">
                    <h4 class="text-green-700 font-bold border-b pb-2 flex items-center gap-2">
                        <span class="bg-green-700 text-white w-5 h-5 rounded-full flex items-center justify-center text-xs">2</span>
                        Supervisor de Estágio
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold uppercase text-gray-500">Nome Completo *</label>
                            <input name="supervisor[nome]" value="<?= htmlspecialchars($old['supervisor']['nome'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">CPF * (XXX.XXX.XXX-XX)</label>
                            <input name="supervisor[cpf]" value="<?= htmlspecialchars($old['supervisor']['cpf'] ?? '') ?>" placeholder="111.222.333-44" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Cargo *</label>
                            <input name="supervisor[cargo]" value="<?= htmlspecialchars($old['supervisor']['cargo'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Formação Acadêmica *</label>
                            <input name="supervisor[formacao_academica]" value="<?= htmlspecialchars($old['supervisor']['formacao_academica'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">E-mail *</label>
                            <input name="supervisor[email]" type="email" value="<?= htmlspecialchars($old['supervisor']['email'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">Registro Profissional *</label>
                                <input name="supervisor[registro_profissional][numero]" value="<?= htmlspecialchars($old['supervisor']['registro_profissional']['numero'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">Órgão Emissor *</label>
                                <input name="supervisor[registro_profissional][orgao]" value="<?= htmlspecialchars($old['supervisor']['registro_profissional']['orgao'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t space-y-4">
                    <h4 class="text-green-700 font-bold border-b pb-2 flex items-center gap-2">
                        <span class="bg-green-700 text-white w-5 h-5 rounded-full flex items-center justify-center text-xs">3</span>
                        Dados do Estagiário
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold uppercase text-gray-500">Nome Completo *</label>
                            <input name="estagiario[nome]" value="<?= htmlspecialchars($old['estagiario']['nome'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Prontuário *</label>
                            <input name="estagiario[prontuario]" value="<?= htmlspecialchars($old['estagiario']['prontuario'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">CPF * (XXX.XXX.XXX-XX)</label>
                            <input name="estagiario[cpf]" value="<?= htmlspecialchars($old['estagiario']['cpf'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">RG * (XX.XXX.XXX-X)</label>
                            <input name="estagiario[rg]" value="<?= htmlspecialchars($old['estagiario']['rg'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Data de Nascimento *</label>
                            <input name="estagiario[data_nascimento]" type="date" value="<?= htmlspecialchars($old['estagiario']['data_nascimento'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Período *</label>
                            <select name="estagiario[periodo]" required class="w-full border p-2 rounded text-sm">
                                <option value="Matutino" <?= ($old['estagiario']['periodo'] ?? '') == 'Matutino' ? 'selected' : '' ?>>Matutino</option>
                                <option value="Vespertino" <?= ($old['estagiario']['periodo'] ?? '') == 'Vespertino' ? 'selected' : '' ?>>Vespertino</option>
                                <option value="Noturno" <?= ($old['estagiario']['periodo'] ?? '') == 'Noturno' ? 'selected' : '' ?>>Noturno</option>
                                <option value="Diurno" <?= ($old['estagiario']['periodo'] ?? '') == 'Diurno' ? 'selected' : '' ?>>Diurno</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Celular * (XX) XXXXX-XXXX</label>
                            <input name="estagiario[celular]" value="<?= htmlspecialchars($old['estagiario']['celular'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">E-mail *</label>
                            <input name="estagiario[email]" type="email" value="<?= htmlspecialchars($old['estagiario']['email'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded border border-dashed">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-bold uppercase text-gray-400">Endereço Estagiário *</label>
                            <input name="estagiario[endereco][endereco]" value="<?= htmlspecialchars($old['estagiario']['endereco']['endereco'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-400">CEP *</label>
                            <input name="estagiario[endereco][cep]" value="<?= htmlspecialchars($old['estagiario']['endereco']['cep'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-400">Bairro *</label>
                            <input name="estagiario[endereco][bairro]" value="<?= htmlspecialchars($old['estagiario']['endereco']['bairro'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-400">Cidade *</label>
                            <input name="estagiario[endereco][cidade]" value="<?= htmlspecialchars($old['estagiario']['endereco']['cidade'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-400">Estado *</label>
                            <input name="estagiario[endereco][estado]" maxlength="2" value="<?= htmlspecialchars($old['estagiario']['endereco']['estado'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                        </div>
                    </div>

                    <div class="flex gap-6 mt-2">
                        <label class="flex items-center gap-2 text-xs font-bold uppercase cursor-pointer">
                            <input type="checkbox" name="estagiario[estagio_obrigatorio]" value="1" <?= ($old['estagiario']['estagio_obrigatorio'] ?? '') ? 'checked' : '' ?>> Estágio Obrigatório
                        </label>
                        <label class="flex items-center gap-2 text-xs font-bold uppercase cursor-pointer">
                            <input type="checkbox" name="estagiario[portador_de_deficiencia]" value="1" <?= ($old['estagiario']['portador_de_deficiencia'] ?? '') ? 'checked' : '' ?>> Portador de Deficiência
                        </label>
                    </div>
                </div>

                <div class="pt-6 border-t space-y-4">
                    <h4 class="text-green-700 font-bold border-b pb-2 flex items-center gap-2">
                        <span class="bg-green-700 text-white w-5 h-5 rounded-full flex items-center justify-center text-xs">4</span>
                        Período, Horários e Seguro
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Data Início *</label>
                            <input name="dados_estagio[data_inicio]" type="date" value="<?= htmlspecialchars($old['dados_estagio']['data_inicio'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Data Término *</label>
                            <input name="dados_estagio[data_termino]" type="date" value="<?= htmlspecialchars($old['dados_estagio']['data_termino'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Horário Início * (HH:MM)</label>
                            <input name="dados_estagio[horario_inicio]" type="time" value="<?= htmlspecialchars($old['dados_estagio']['horario_inicio'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Horário Término * (HH:MM)</label>
                            <input name="dados_estagio[horario_termino]" type="time" value="<?= htmlspecialchars($old['dados_estagio']['horario_termino'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Horas Semanais *</label>
                            <input name="dados_estagio[horas_semanais]" type="number" value="<?= htmlspecialchars($old['dados_estagio']['horas_semanais'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Bolsa-Auxílio (R$) *</label>
                            <input name="dados_estagio[valor_bolsa_auxilio]" type="number" step="0.01" value="<?= htmlspecialchars($old['dados_estagio']['valor_bolsa_auxilio'] ?? '') ?>" required class="w-full border p-2 rounded text-sm">
                        </div>
                    </div>

                    <div class="bg-blue-50 p-4 rounded border border-blue-200 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-3 font-bold text-blue-800 text-xs uppercase">Dados do Seguro de Vida</div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Seguradora *</label>
                            <input name="dados_estagio[nome_seguradora]" value="<?= htmlspecialchars($old['dados_estagio']['nome_seguradora'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Nº Apólice *</label>
                            <input name="dados_estagio[numero_apolice_seguro]" value="<?= htmlspecialchars($old['dados_estagio']['numero_apolice_seguro'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold uppercase text-gray-500">Valor Seguro (R$) *</label>
                            <input name="dados_estagio[valor_seguro]" type="number" step="0.01" value="<?= htmlspecialchars($old['dados_estagio']['valor_seguro'] ?? '') ?>" required class="w-full border p-2 rounded text-sm bg-white">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center pt-10">
                    <button type="submit" class="w-full md:w-1/2 bg-[#006633] text-white font-bold py-4 rounded-lg hover:bg-[#004d26] shadow-xl text-lg transition-all">
                        Validar e Gerar PDF
                    </button>
                </div>
            </form>
        </section>
    </div>
<?php } ?>