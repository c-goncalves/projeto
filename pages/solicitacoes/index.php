<?php
require_once __DIR__ . '/../../includes/header.php';
$page_title = "Solicitação de Estágio";

$curso = $_GET['curso'] ?? null;
$step  = $_GET['step']  ?? 'inicio';
// $tipo  = $_GET['tipo']  ?? null;

$include_file = __DIR__ . '/inicio.php';
// $include_file = '';

if ($curso && $step !== 'inicio') {
    switch ($step) {
        case '2':
            $include_file = __DIR__ . '/forms/termo-' . $curso . '.php';
            break;

        case '3':
            $include_file = __DIR__ . '/forms/plano-' . $curso . '.php';
            break;
        case '4':
            $include_file = __DIR__ . '/forms/fpdf/gerar_termo_estagio.php';
            break;

    }
}
// if ($step === 'inicio') {
//     $include_file = __DIR__ . '/cursos/inicio.php';
// } elseif ($tipo && $curso && $step) {
//     // $include_file = __DIR__ . '/cursos/' . $step . '-' . $tipo . '-' . $curso . '.php';
//     $include_file = __DIR__ . '/cursos/' . $tipo . '/' . $curso . '/' . $step . '.php';

// }

if ($include_file && file_exists($include_file)) {
    include $include_file;
} else {
    // echo "<div class='msg error'>Etapa não encontrada: " . htmlspecialchars($step) . "</div>";
    include __DIR__ . '/inicio.php';
}

require_once __DIR__ . '/../../includes/footer.php';
?>

