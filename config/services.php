<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteParserInterface;
use App\Controllers\SiteController;
use App\Controllers\DocumentoController;

return [
    
    // 1. Dependências essenciais)
    
    // obter a instância do RouteParser
    RouteParserInterface::class => function (ContainerInterface $container): RouteParserInterface {
        $app = $container->get(App::class); 
        return $app->getRouteCollector()->getRouteParser();
    },

    // 2. CONTROLLERS
    
    SiteController::class => function (ContainerInterface $container) {
        $routeParser = $container->get(RouteParserInterface::class);
        return new SiteController($routeParser);
    },

    DocumentoController::class => function (ContainerInterface $container) {
        $routeParser = $container->get(RouteParserInterface::class);
        // $dbConnection = $container->get(DB::class);
        return new DocumentoController($routeParser); 
    },

    // 3. VARIÁVEIS GLOBAIS
    'db.settings' => [
        'host' => 'db', 
        'user' => 'user',
        'pass' => 'password_secret',
        'dbname' => 'estagio_db',
    ],
    
    // outros serviços(logs, renderização de Twig, etc.)
];