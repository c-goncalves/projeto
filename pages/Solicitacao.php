<?php
require_once __DIR__ . '/../templates/partials/header.php';
echo '<link rel="stylesheet" href="' . ASSETS_URL . 'css/form-styles.css">';

if (session_status() === PHP_SESSION_NONE) {
    session_start();    
}


function inicio() {
    require_once __DIR__ . '/../templates/partials/nav.php';
    require_once __DIR__ . '/../templates/solicitacoes/inicio.php';
}

function termo($documento, $tipo_estagio) {
    $curso = $_GET['curso'] ?? 'licenciatura';
    include __DIR__ . "/../templates/solicitacoes/forms/tce_obrigatorio.php";
    print_termo_licenciatura_page(BASE_URL, $_SERVER['REQUEST_URI']);

    $curso_sufixo = '-lic'; 
    $template_file = $documento . $curso_sufixo . '.php'; 
    $include_path = $base_forms . $template_file;
    global $tipo_estagio_atual;
    $tipo_estagio_atual = $tipo_estagio; 

    if (file_exists($include_path)) {
        require_once $include_path;
    } else {
        die("Erro: Formulário {$template_file} não encontrado.");
    }
    

}

function plano() {
    $curso = $_GET['curso'] ?? 'licenciatura';
    include __DIR__ . '/../templates/partials/nav.php';
    include __DIR__ . "/_forms/plano-{$curso}.php";
}

function gerar_pdf() {
    include __DIR__ . '/../templates/partials/nav.php';
    include __DIR__ . '/_pdf/gerar_termo_estagio.php';
}



$acao = $_GET['acao'] ?? 'inicio';
if (!function_exists($acao)) $acao = 'inicio';
call_user_func($acao);

echo '<script src="' . ASSETS_URL . 'js/form-scripts.js" defer></script>';
require_once __DIR__ . '/../templates/partials/footer.php';


