<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
// corrija a namespace conforme a sua classe real
use App\Middleware\AuthMiddleware; 
use App\Middleware\UrlSlashMiddleware; 

return function (\Slim\App $app) {

    $controllerNamespace = 'App\\Controllers\\';

    // home
    $app->get('/', $controllerNamespace . 'SiteController:index')->setName('site.index');

    $slashMiddleware = new \App\Middleware\UrlSlashMiddleware('remove', 301);

    $app->group('/solicitacao', function (RouteCollectorProxy $group) use ($controllerNamespace) {
    // index
        $group->get('', $controllerNamespace . 'SolicitacaoController:home')
            ->setName('solicitacao.index');

        // TERMO / TCE  — rota legada ('termo') + rota técnica ('tce')
        $group->get('/termo[/{tipo}]', $controllerNamespace . 'SolicitacaoController:termo')
            ->setName('solicitacao.termo'); // nome legado
        $group->get('/tce[/{tipo}]', $controllerNamespace . 'SolicitacaoController:termo')
            ->setName('solicitacao.tce');   // nome "técnico" (usado nos templates)

        // PLANO / PAE — rota legada ('plano') + rota técnica ('pae')
        $group->get('/plano[/{tipo}]', $controllerNamespace . 'SolicitacaoController:plano')
            ->setName('solicitacao.plano'); // nome legado
        $group->get('/pae[/{tipo}]', $controllerNamespace . 'SolicitacaoController:plano')
            ->setName('solicitacao.pae');   // nome "pae" (usado nos templates)

        // demais documentos
        $group->get('/ta[/{tipo}]',   $controllerNamespace . 'SolicitacaoController:ta')->setName('solicitacao.ta');
        $group->get('/trtc[/{tipo}]', $controllerNamespace . 'SolicitacaoController:trtc')->setName('solicitacao.trtc');

        // checklist (mantive)
        $group->get('/checklist', $controllerNamespace . 'SolicitacaoController:gerarChecklist')
            ->setName('solicitacao.checklist');

        // POST
        $group->post('/enviar', $controllerNamespace . 'SolicitacaoController:processarEnvio')
            ->setName('solicitacao.enviar');
    })->add($slashMiddleware);



    $app->get('/recursos', $controllerNamespace . 'SiteController:recursos')->setName('site.recursos');

    $app->group('/acompanhamento', function (RouteCollectorProxy $group) use ($controllerNamespace) {
        $group->get('', $controllerNamespace . 'AcompanhamentoController:index')->setName('acompanhamento.index');
    });

    $app->group('/noticias', function (RouteCollectorProxy $group) use ($controllerNamespace) {
        $group->get('', $controllerNamespace . 'NoticiasController:index')->setName('noticias.index');
    });

    $app->get('/login', $controllerNamespace . 'AuthController:showLogin')->setName('login.show');

    // rotas protegidas (exemplo de uso do AuthMiddleware)
    // $app->group('/dashboard', function (RouteCollectorProxy $group) use ($controllerNamespace) {
    //     $group->get('', $controllerNamespace . 'DashboradController:showDashboard')->setName('dashboard.index');
    // })->add(new AuthMiddleware('/login'));
};
