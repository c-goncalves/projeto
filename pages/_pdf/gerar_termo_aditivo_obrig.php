<?php
// ATENÇÃO: Habilita a exibição de erros para depuração (MUITO IMPORTANTE para ver se o mPDF está falhando)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// require_once __DIR__ . '/../../../../../vendor/autoload.php';
$autoload_path = BASE_PATH . 'vendor/autoload.php';
// require_once BASE_PATH . 'vendor/autoload.php';
require_once $autoload_path; 

use Mpdf\Mpdf;
use Mpdf\MpdfException;

// O caminho do config/db.php foi COMENTADO pois não estamos usando o banco.
// include '../../../config/db.php'; 

// --- Dados Estáticos para Teste (Estes dados viriam do banco em produção) ---
$alunoNome = "Carolina da Silva (TESTE)";
$alunoProntuario = "2024.1.99.999.9";
$alunoRG = "99.999.999-X";
$alunoCPF = "999.999.999-99";
$alunoDataNasc = "10/05/2000";
$alunoEndereco = "Rua Teste, 123";
$alunoCEP = "07115-000";
$alunoBairro = "Vila Rio";
$alunoCidade = "Guarulhos";
$alunoEstado = "SP";
$alunoFone = "(11) 9999-9999";
$alunoCel = "(11) 98888-8888";
$alunoEmail = "teste@ifsp.edu.br";
$alunoCurso = "Licenciatura em Matemática";
$alunoPeriodo = "3º Semestre";
$alunoEstagioTipo = "Obrigatório"; 

$empresaRazaoSocial = "Escola Estadual de Testes S.A.";
$empresaCNPJ = "12.345.678/0001-99";
$empresaInscEstadual = "999.888.777.666";
$empresaEndereco = "Rua das Simulações, 100";
$empresaCEP = "07000-000";
$empresaBairro = "Centro";
$empresaCidade = "Guarulhos";
$empresaEstado = "SP";
$empresaRepresentante = "Dr. Teste da Silva";
$empresaCargoRepresentante = "Diretor";
$empresaFone = "(11) 2345-6789";

$supervisorNome = "Dra. Ana Costaaa";
$supervisorCPF = "111.222.333-44";
$supervisorCargo = "Professor Supervisor";
$supervisorFormacao = "Pedagogia";
$supervisorRegProf = "CREA/SP 123456";
$supervisorOrgao = "CREA";
$supervisorEmail = "ana.costa@escola.com";

$dataInicio = "01/03/2026";
$dataFim = "30/08/2026";
$horarioEstagio = "Segunda a Sexta, das 14:00h às 18:00h (4 horas diárias / 20h semanais)";
$bolsaAuxilioNumerico = "1500,00"; 
$bolsaAuxilioExtenso = "Mil e quinhentos reais";
$seguroNumero = "987654321";
$seguroNome = "Seguradora IFSP";
$seguroValor = "R$ 50.000,00 (Cinquenta mil reais)";
$jornadaDescricao = "06 (seis) horas diárias e 30 (trinta) horas semanais";


// Lógica para preencher os marcadores X (Obrigatório/Não Obrigatório)
$estagioObrigatorioX = ($alunoEstagioTipo === "Obrigatório") ? "X" : "";
$estagioNaoObrigatorioX = ($alunoEstagioTipo === "Não Obrigatório") ? "X" : "";
$pcdX = ""; // Não Portador de Deficiência

// Lógica de seguro para Cláusula Quarta
$apóliceSeguro = ($alunoEstagioTipo === "Obrigatório") 
    ? "O IFSP se responsabiliza pela contratação de seguro contra acidentes pessoais em nome do ESTAGIÁRIO, conforme previsto no Parágrafo único do Art. 9º da Lei 11.788, em nome do aluno estagiário, durante a realização do estágio obrigatório." 
    : "o ESTAGIÁRIO estará coberto pela apólice de seguro n° {$seguroNumero}, da Seguradora {$seguroNome} no valor de {$seguroValor} contra Acidentes Pessoais.";


// 2.1. Carrega o template HTML modularizado
$template_path = __DIR__ . '../layouts/termo_aditivo_obrig.html';

if (!file_exists($template_path)) {
    $template_path = __DIR__ . '/../../layouts/termo_aditivo_obrig.html'; 
    if (!file_exists($template_path)) {
        $template_path = __DIR__ . '/../layouts/termo_aditivo_obrig.html'; 
        if (!file_exists($template_path)) {
            die("Erro FATAL: Arquivo de layout do Termo (termo_aditivo_obrig.html) não encontrado. Tente verificar o caminho absoluto: " . $template_path);
        }
    }
}

$html_template = file_get_contents($template_path);
$logoPath = BASE_PATH . 'assets/logo_termo2.jpg';

// 2.2. Array de Substituições
$substituicoes = [
    '{{LOGO_PATH}}' => htmlspecialchars($logoPath),
    '{{ALUNOOME}}' => htmlspecialchars($alunoNome),
    '{{ALUNO_PRONTUARIO}}' => htmlspecialchars($alunoProntuario),
    '{{ALUNO_RG}}' => htmlspecialchars($alunoRG),
    '{{ALUNO_CPF}}' => htmlspecialchars($alunoCPF),
    '{{ALUNO_DATAASC}}' => $alunoDataNasc,
    '{{ALUNO_ENDERECO}}' => htmlspecialchars($alunoEndereco),
    '{{ALUNO_CEP}}' => htmlspecialchars($alunoCEP),
    '{{ALUNO_BAIRRO}}' => htmlspecialchars($alunoBairro),
    '{{ALUNO_CIDADE}}' => htmlspecialchars($alunoCidade),
    '{{ALUNO_ESTADO}}' => htmlspecialchars($alunoEstado),
    '{{ALUNO_FONE}}' => htmlspecialchars($alunoFone),
    '{{ALUNO_CEL}}' => htmlspecialchars($alunoCel),
    '{{ALUNO_EMAIL}}' => htmlspecialchars($alunoEmail),
    '{{ALUNO_CURSO}}' => htmlspecialchars($alunoCurso),
    '{{ALUNO_PERIODO}}' => htmlspecialchars($alunoPeriodo),
    '{{ESTAGIO_OBRIGATORIO_X}}' => $estagioObrigatorioX,
    '{{ESTAGIOAO_OBRIGATORIO_X}}' => $estagioNaoObrigatorioX,
    '{{PCD_X}}' => $pcdX,

    '{{EMPRESA_RAZAO_SOCIAL}}' => htmlspecialchars($empresaRazaoSocial),
    '{{EMPRESA_CNPJ}}' => htmlspecialchars($empresaCNPJ),
    '{{EMPRESA_INSCRICAO_ESTADUAL}}' => htmlspecialchars($empresaInscEstadual),
    '{{EMPRESA_REPRESENTANTE}}' => htmlspecialchars($empresaRepresentante),
    '{{EMPRESA_CARGO_REPRESENTANTE}}' => htmlspecialchars($empresaCargoRepresentante),
    '{{EMPRESA_ENDERECO}}' => htmlspecialchars($empresaEndereco),
    '{{EMPRESA_CEP}}' => htmlspecialchars($empresaCEP),
    '{{EMPRESA_BAIRRO}}' => htmlspecialchars($empresaBairro),
    '{{EMPRESA_CIDADE}}' => htmlspecialchars($empresaCidade),
    '{{EMPRESA_ESTADO}}' => htmlspecialchars($empresaEstado),
    '{{EMPRESA_FONE}}' => htmlspecialchars($empresaFone),

    '{{SUPERVISOROME}}' => htmlspecialchars($supervisorNome),
    '{{SUPERVISOR_CPF}}' => htmlspecialchars($supervisorCPF),
    '{{SUPERVISOR_CARGO}}' => htmlspecialchars($supervisorCargo),
    '{{SUPERVISOR_FORMACAO}}' => htmlspecialchars($supervisorFormacao),
    '{{SUPERVISOR_REG_PROF}}' => htmlspecialchars($supervisorRegProf),
    '{{SUPERVISOR_ORGAO}}' => htmlspecialchars($supervisorOrgao),
    '{{SUPERVISOR_EMAIL}}' => htmlspecialchars($supervisorEmail),

    '{{DATA_INICIO}}' => $dataInicio,
    '{{DATA_FIM}}' => $dataFim,
    '{{HORARIO_ESTAGIO}}' => htmlspecialchars($horarioEstagio),
    '{{JORNADA_DESCRICAO}}' => htmlspecialchars($jornadaDescricao),
    '{{APOLICE_SEGURO_TEXTO}}' => $apóliceSeguro,
    '{{ATIVIDADES_PRINCIPAIS}}' => nl2br(htmlspecialchars($atividadesPrincipais)),
    
    '{{BOLSAUMERICA}}' => $bolsaAuxilioNumerico,
    '{{BOLSA_EXTENSO}}' => $bolsaAuxilioExtenso,
    
    '{{DATA_ATUAL_DIA}}' => date("d"),
    '{{DATA_ATUAL_MES}}' => date("F"),
    '{{DATA_ATUAL_ANO}}' => date("Y"),
];


// 2.3. Executa a substituição
$html = str_replace(
    array_keys($substituicoes), 
    array_values($substituicoes), 
    $html_template
);

// === 3. PROCESSAMENTO mPDF ===
try {
    $mpdf = new Mpdf([
        'format' => 'A4',
        'margin_left' => 24,
        'margin_right' => 14,
        'margin_top' => 14,
        'margin_bottom' => 14,
        'tempDir' => __DIR__ . '/tmp'
    ]);
    $mpdf->showImageErrors = true;
    $mpdf->SetTitle("Termo de Estágio - " . $alunoNome);
    $mpdf->WriteHTML($html);

    // Saída do PDF no navegador (I = Inline/Abrir no navegador)
    $mpdf->Output("termo_aditivo_obrig_" . str_replace('.', '_', $alunoProntuario) . ".pdf", 'I');
    
} catch (MpdfException $e) {
    // Captura erros de geração do PDF
    die("Erro ao gerar PDF: " . $e->getMessage());
}

?>

