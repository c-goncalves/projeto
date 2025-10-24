<?php
/**
 * definicao das rotas
 * 
 * COMO USAR:
 * $router->get('rota', 'página.php');
 * $router->get('rota/{parametro}', 'página.php');
 * $router->get('rota/{param1}/{param2}', 'página.php');
 */

// RAIZ
$router->get('', 'home');
// $router->get('/', 'home'); 

// ASSESTS
$router->get('assest', 'assets');

// SOLICITAÇÕES 
$router->get('solicitacoes', 'solicitacoes/index');
$router->get('solicitacoes/{curso}/form/{step}', 'solicitacoes/index');
// GERAR PDF (teste temporário)
$router->get('solicitacoes/form/pdf/gerar-termo', 'solicitacoes/forms/pdf/gerar_termo_estagio');

// $router->get('solicitacoes/{step}', 'solicitacoes/index');
// $router->get('solicitacoes/cursos/form/{step}', 'solicitacoes/index');
// $router->get('solicitacoes/cursos/{tipo}/{curso}/{step}', 'solicitacoes/index');


// ANDAMENTO 
$router->get('andamento', 'andamento/index');
$router->get('andamento/{step}', 'andamento/index');

// ENCERRAMENTO 
$router->get('encerramento', 'encerramento/index');
$router->get('encerramento/{step}', 'encerramento/index');

// RECURSOS 
$router->get('recursos', 'recursos/index');

// NOTÍCIAS 
$router->get('noticias', 'noticias/index');
$router->get('noticias/{step}', 'noticias/index');

// ESTÁTICAS 
$router->get('sobre', 'sobre');
$router->get('contato', 'contato');

?>
