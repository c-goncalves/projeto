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


function tce() {
    $documento_base = 'tce'; 
    $curso = $_GET['curso'] ?? 'outros';
    // $curso = $_GET['curso'] ?? 'licenciatura';
    $base_forms = __DIR__ . "/../templates/solicitacoes/forms/";
    
    if (strtolower($curso) === 'lic') {
        $template_name = $documento_base . '_lic.php';
    } else {
        $template_name = $documento_base . '.php';
    }
    
    $include_path = $base_forms . $template_name;

    if (file_exists($include_path)) {
        require_once $include_path;
    } else {
        error_log("termo(): Formulário não encontrado: {$include_path}");
        echo "<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro: O template ({$template_name}) não encontrado.</div>";
        return;
    }

    $current_uri = $_SERVER['REQUEST_URI'] ?? '';
    if (function_exists('print_termo')) {
        print_termo(BASE_URL, $current_uri, $curso);
    } else {
        echo "<div class=\"p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800\">print_termo não está carregada.</div>";
    }
}

function pae() {
    $documento_base = 'pae'; 
    $curso = $_GET['curso'] ?? 'outros';
    // $curso = $_GET['curso'] ?? 'licenciatura';
    $base_forms = __DIR__ . "/../templates/solicitacoes/forms/";
    
    if (strtolower($curso) === 'lic') {
        $template_name = $documento_base . '_lic.php';
    } else {
        $template_name = $documento_base . '.php';
    }
    
    $include_path = $base_forms . $template_name;

    if (file_exists($include_path)) {
        require_once $include_path;
    } else {
        error_log("termo(): Formulário não encontrado: {$include_path}");
        echo "<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro: O template ({$template_name}) não encontrado.</div>";
        return;
    }

    $current_uri = $_SERVER['REQUEST_URI'] ?? '';
    if (function_exists('print_pae')) {
        print_pae(BASE_URL, $current_uri, $curso);
    } else {
        echo "<div class=\"p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800\">print_pae não está carregada.</div>";
    }

}
function rsem() {
    $documento_base = 'rsem'; 
    $base_forms = __DIR__ . "/../templates/solicitacoes/forms/";
    $template_name = $documento_base . '.php';
    $include_path = $base_forms . $template_name;

    if (file_exists($include_path)) {
        require_once $include_path;
    } else {
        error_log("termo(): Formulário não encontrado: {$include_path}");
        echo "<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro: O template ({$template_name}) não encontrado.</div>";
        return;
    }

    $current_uri = $_SERVER['REQUEST_URI'] ?? '';
    if (function_exists('print_rsem')) {
        print_rsem(BASE_URL, $current_uri);
    } else {
        echo "<div class=\"p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800\">print_rsem não está carregada.</div>";
    }

}

function ta() {
    $documento_base = 'ta'; 
    $curso = $_GET['curso'] ?? 'outros';
    // $curso = $_GET['curso'] ?? 'licenciatura';
    $base_forms = __DIR__ . "/../templates/solicitacoes/forms/";
    
    if (strtolower($curso) === 'lic') {
        $template_name = $documento_base . '_lic.php';
    } else {
        $template_name = $documento_base . '.php';
    }
    
    $include_path = $base_forms . $template_name;

    if (file_exists($include_path)) {
        require_once $include_path;
    } else {
        error_log("termo(): Formulário não encontrado: {$include_path}");
        echo "<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro: O template ({$template_name}) não encontrado.</div>";
        return;
    }

    $current_uri = $_SERVER['REQUEST_URI'] ?? '';
    if (function_exists('print_termo_aditivo')) {
        print_termo_aditivo(BASE_URL, $current_uri, $curso);
    } else {
        echo "<div class=\"p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800\">print_termo_aditivo não está carregada.</div>";
    }
}

function trtc() {
    $documento_base = 'trtc'; 
    $curso = $_GET['curso'] ?? 'outros';
    // $curso = $_GET['curso'] ?? 'licenciatura';
    $base_forms = __DIR__ . "/../templates/solicitacoes/forms/";
    
    if (strtolower($curso) === 'lic') {
        $template_name = $documento_base . '_lic.php';
    } else {
        $template_name = $documento_base . '.php';
    }
    
    $include_path = $base_forms . $template_name;

    if (file_exists($include_path)) {
        require_once $include_path;
    } else {
        error_log("termo(): Formulário não encontrado: {$include_path}");
        echo "<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro: O template ({$template_name}) não encontrado.</div>";
        return;
    }

    $current_uri = $_SERVER['REQUEST_URI'] ?? '';
    if (function_exists('print_rescisao')) {
        print_rescisao(BASE_URL, $current_uri, $curso);
    } else {
        echo "<div class=\"p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800\">print_rescisao não está carregada.</div>";
    }
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


