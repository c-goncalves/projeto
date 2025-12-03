<?php
define('BASE_PATH', dirname(__DIR__) . '/');

$base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
define('BASE_URL', ($base_url == '') ? '/' : $base_url . '/');

// Outros caminhos
define('CONFIG_PATH', BASE_PATH . 'config/');
define('PAGES_PATH', BASE_PATH . 'pages/');
define('TEMPLATES_PATH', BASE_PATH . 'templates/');
define('ASSETS_URL', BASE_URL . 'assets/');
define('PARTIALS_PATH', BASE_PATH . 'templates/partials/');