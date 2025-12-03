<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use App\Middlewares\AuthMiddleware;

return function (\Slim\App $app) {
    
    //home
    // $app->get('/', 'App\Controllers\SiteController:home');
    $app->get('/', 'App\Controllers\SiteController:home')->setName('site.home');
    // teste de rota
    // $app->get('/', function (Request $request, Response $response) {
    //     $response->getBody()->write("Bem-vindo! Esta é a página inicial da sua aplicação.");
    //     return $response;
    // });
    $app->get('/test', function (Request $request, Response $response) {
         $response->getBody()->write("TESTE OK");
         return $response;
    });
    

    $app->group('/solicitacao', function (RouteCollectorProxy $group) {
        $group->get('/termo/{tipo}', '\App\Controllers\SolicitacaoController:termo');
        $group->get('/plano/{tipo}', '\App\Controllers\SolicitacaoController:plano');
        $group->get('/checklist', '\App\Controllers\SolicitacaoController:gerarChecklist');
        
        // POST
        $group->post('/enviar', '\App\Controllers\SolicitacaoController:processarEnvio');
        
    });
    
    $app->get('/login', '\App\Controllers\AuthController:showLogin');

    // rotas protegidas
    $app->group('/coordenador', function (RouteCollectorProxy $group) {
        $group->get('/dashboard', 'App\Controllers\CoordenadorController:showDashboard');
        $group->get('/estagios', 'App\Controllers\CoordenadorController:listEstagios');
    })->add(new AuthMiddleware());

    
};