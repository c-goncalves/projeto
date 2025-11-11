<?php
// pages/index.php — página inicial de Solicitação de Estágio (refatorada)

// Cabeçalho padrão
require_once __DIR__ . '/../templates/partials/header.php';
$page_title = "Solicitação de Estágio";

// Obtém parâmetros de navegação
$curso = $_GET['curso'] ?? null;
$step  = $_GET['step'] ?? 'inicio';

// Caminho base dos formulários
$base_forms = __DIR__ . '/_forms/';
$base_pdf   = __DIR__ . '/_pdf/';

// Define arquivo padrão (página inicial)
$include_file = __DIR__ . '/Solicitacao.php';

// Lógica de inclusão condicional
if ($curso && $step !== 'inicio') {
    switch ($step) {
        case '2':
            $include_file = $base_forms . 'termo-' . $curso . '.php';
            break;

        case '3':
            $include_file = $base_forms . 'plano-' . $curso . '.php';
            break;

        case '4':
            $include_file = $base_pdf . 'gerar_termo_estagio.php';
            break;
    }
}

// Renderiza o conteúdo
if (file_exists($include_file)) {
    include $include_file;
} else {
    include __DIR__ . '/Solicitacao.php'; // fallback
}

// Rodapé padrão
require_once __DIR__ . '/../templates/partials/footer.php';
?>
