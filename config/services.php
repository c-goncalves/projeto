<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Interfaces\RouteParserInterface;
use App\Controllers\SiteController;
use App\Controllers\SolicitacaoController;

return [

    // PSR-17
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
            // PDO::ATTR_PERSISTENT => true, // opcional
        ];

        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Falha ao conectar ao banco de dados: ' . $e->getMessage(), 0, $e);
        }
    },

    // permitir injeção por type-hint PDO::class
    PDO::class => function (ContainerInterface $c) {
        return $c->get('db');
    },

    // try {
    //     return new PDO($dsn, $user, $pass, $options);
    // } catch (\PDOException $e) {
    //     // Lança uma RuntimeException com contexto (pode logar aqui se desejar)
    //     throw new \RuntimeException('Falha ao conectar ao banco de dados: ' . $e->getMessage(), 0, $e);
    // }

    // Controllers
    SiteController::class => function (Psr\Container\ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class)
            ? $c->get(RouteParserInterface::class)
            : null;
        $db = $c->has(PDO::class) ? $c->get(PDO::class) : null;
        return new SiteController($routeParser, $db);
    },

    SolicitacaoController::class => function (ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class)
            ? $c->get(RouteParserInterface::class)
            : null;
        $db = $c->has(PDO::class) ? $c->get(PDO::class) : null;
        return new SolicitacaoController($routeParser, $db);
    },

   GerarPDFController::class => function (ContainerInterface $c) {
        $routeParser = $c->get(RouteParserInterface::class);
        $db = $c->get(PDO::class); 
        return new GerarPDFController($routeParser, $db);
    },

    AcompanhamentoController::class => function (ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class)
            ? $c->get(RouteParserInterface::class)
            : null;
        $db = $c->has(PDO::class) ? $c->get(PDO::class) : null;
        return new AcompanhamentoController($routeParser, $db);
    },

];
