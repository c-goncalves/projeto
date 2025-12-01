<?php
session_start();

/**
 * ===============================================
 *  Configuração de caminhos globais
 * ===============================================
 */
define('BASE_PATH', __DIR__ . '/');
define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/');
define('CONFIG_PATH', BASE_PATH . 'config/');
define('PAGES_PATH', BASE_PATH . 'pages/');
define('TEMPLATES_PATH', BASE_PATH . 'templates/');
define('ASSETS_URL', BASE_URL . 'assets/');
define('PARTIALS_PATH', BASE_PATH . 'templates/partials/');


/**
 * ===============================================
 *  Dependências principais
 * ===============================================
 */
require_once CONFIG_PATH . 'db.php';
require_once CONFIG_PATH . 'Router.php';
require_once CONFIG_PATH . 'functions.php';

/**
 * ===============================================
 *  Inicializa o roteador antes das rotas
 * ===============================================
 */
$router = new Router();

/**
 * ===============================================
 *  Carrega o mapa de rotas
 * ===============================================
 */
require_once CONFIG_PATH . 'routes/web.php';

/**
 * ===============================================
 *  Despacha a rota atual
 * ===============================================
 */
$router->dispatch();
?>
