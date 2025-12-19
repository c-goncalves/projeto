<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\AuthMiddleware; 
use App\Middleware\UrlSlashMiddleware; 

return function (\Slim\App $app) {

    $controllerNamespace = 'App\\Controllers\\';

    // home
    $app->get('/', $controllerNamespace . 'SiteController:index')->setName('site.index');

    $slashMiddleware = new \App\Middleware\UrlSlashMiddleware('remove', 301);

    $app->group('/solicitacao', function (RouteCollectorProxy $group) use ($controllerNamespace) {
        
        $group->get('', $controllerNamespace . 'SolicitacaoController:home')
            ->setName('solicitacao.index');

   
        $group->post('/processar', $controllerNamespace . 'SolicitacaoController:processarEnvio')
            ->setName('solicitacao.processar');

        $group->get('/enviar', $controllerNamespace . 'SolicitacaoController:enviarDocumento')
            ->setName('solicitacao.enviar');

        $group->post('/upload', $controllerNamespace . 'SolicitacaoController:processarUpload')
            ->setName('solicitacao.upload');

        $group->get('/tce[/{tipo}]', $controllerNamespace . 'SolicitacaoController:termo')
            ->setName('solicitacao.termo');   
        
        $group->get('/pae[/{tipo}]', $controllerNamespace . 'SolicitacaoController:plano')
            ->setName('solicitacao.plano');   

        $group->get('/ta[/{tipo}]',   $controllerNamespace . 'SolicitacaoController:ta')->setName('solicitacao.ta');
        $group->get('/trtc[/{tipo}]', $controllerNamespace . 'SolicitacaoController:trtc')->setName('solicitacao.trtc');

    })->add($slashMiddleware);

    $app->get('/documento/{tipo}', \App\Controllers\GerarPDFController::class . ':gerarDocumento')
        ->setName('pdf.gerar');

    $app->get('/recursos', $controllerNamespace . 'SiteController:recursos')->setName('site.recursos');

    
   $app->group('/acompanhamento', function (RouteCollectorProxy $group) use ($controllerNamespace) {
        $group->get('', $controllerNamespace . 'AcompanhamentoController:index')->setName('acompanhamento.index');
        $group->post('/resultado', $controllerNamespace . 'AcompanhamentoController:consultar')->setName('acompanhamento.consultar');
    });

    $app->group('/noticias', function (RouteCollectorProxy $group) use ($controllerNamespace) {
        $group->get('', $controllerNamespace . 'NoticiasController:index')->setName('noticias.index');
    });

    $app->get('/login', $controllerNamespace . 'AuthController:showLogin')->setName('login.show');

    
    // $app->group('/dashboard', function (RouteCollectorProxy $group) use ($controllerNamespace) {
    //     $group->get('', $controllerNamespace . 'DashboradController:showDashboard')->setName('dashboard.index');
    // })->add(new AuthMiddleware('/login'));
};
