<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Interfaces\RouteParserInterface;
use App\Controllers\SiteController;
use App\Controllers\SolicitacaoController;
use App\Controllers\GerarPDFController;
use App\Controllers\AcompanhamentoController;

return [

    
    ResponseFactoryInterface::class => function (ContainerInterface $c) {
        return new \Slim\Psr7\Factory\ResponseFactory();
    },

    'db' => function (ContainerInterface $c) {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $name = getenv('DB_NAME') ?: 'estagio_db';
        $user = getenv('DB_USER') ?: 'user';
        $pass = getenv('DB_PASS') ?: 'password_secret';
        $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            
            
            return null; 
        }
    },

    PDO::class => function (ContainerInterface $c) {
        return $c->get('db');
    },

    
    SiteController::class => function (ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class) ? $c->get(RouteParserInterface::class) : null;
        
        $db = $c->has(PDO::class) ? $c->get(PDO::class) : null;
        return new SiteController($routeParser, null);
    },

    SolicitacaoController::class => function (ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class) ? $c->get(RouteParserInterface::class) : null;
        
        return new SolicitacaoController($routeParser);
    },

   GerarPDFController::class => function (ContainerInterface $c) {
        $routeParser = $c->get(RouteParserInterface::class);
        
        
        return new GerarPDFController($routeParser);
    },

    AcompanhamentoController::class => function (ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class) ? $c->get(RouteParserInterface::class) : null;
        
        return new AcompanhamentoController($routeParser);
    },

];