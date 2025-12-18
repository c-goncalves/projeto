<form action="<?= $routeParser->urlFor('solicitacao.upload') ?>" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    
    <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg mb-4 text-blue-800 text-sm">
        <strong>Atenção:</strong> Preencha os dados abaixo exatamente como constam no documento assinado.
    </div>

    <input type="text" name="aluno_nome" placeholder="Seu Nome Completo" required class="p-2 border rounded">
    <input type="email" name="aluno_email" placeholder="Seu E-mail Institucional" required class="p-2 border rounded">
    <input type="text" name="aluno_prontuario" placeholder="Prontuário (Ex: GU300...)" required class="p-2 border rounded">
    
    <select name="curso_id" required class="p-2 border rounded">
        <option value="">Selecione seu Curso</option>
        <option value="4">Análise e Desenvolvimento de Sistemas</option>
        <option value="1">Engenharia de Computação</option>
        </select>

    <input type="text" name="empresa_razao_social" placeholder="Razão Social da Empresa" required class="p-2 border rounded">
    <input type="text" name="empresa_cnpj" placeholder="CNPJ" required class="p-2 border rounded">

    <div>
        <label class="block text-xs text-gray-500">Data de Início</label>
        <input type="date" name="data_inicio" required class="w-full p-2 border rounded">
    </div>
    <div>
        <label class="block text-xs text-gray-500">Data de Término</label>
        <input type="date" name="data_fim" required class="w-full p-2 border rounded">
    </div>

    <div class="md:col-span-2 border-2 border-dashed p-6 text-center">
        <label class="block mb-2 font-bold">Documento Assinado (PDF)</label>
        <input type="file" name="documento_pdf" accept="application/pdf" required>
    </div>

    <button type="submit" class="md:col-span-2 bg-[#006633] text-white font-bold p-3 rounded hover:bg-[#004d26]">
        Enviar para Avaliação do Orientador
    </button>
</form>