<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Interfaces\RouteParserInterface;
use App\Controllers\SiteController;
use App\Controllers\SolicitacaoController;
use App\Services\MailService;
use App\Services\Repository;
use App\Controllers\GerarPDFController;
use App\Controllers\AcompanhamentoController;
use PHPMailer\PHPMailer\PHPMailer;

$basePath = dirname(__DIR__);

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

    PHPMailer::class => function (ContainerInterface $c) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        // $mail->Host       = getenv('SMTP_HOST') ?: 'sandbox.smtp.mailtrap.io';
        // $mail->SMTPAuth   = true;
        // $mail->Username   = getenv('SMTP_USER');
        // $mail->Password   = getenv('SMTP_PASS');
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        // $mail->Port       = getenv('SMTP_PORT') ?: 2525;
        $mail->Host       = 'mailhog';
        $mail->Port       = 1025;
        $mail->SMTPAuth   = false;
        $mail->CharSet    = 'UTF-8';
        $mail->setFrom(getenv('SMTP_FROM') ?: 'no-reply@teste.edu.br', 'CEX IFSP');
        
        return $mail;
    },

    MailService::class => function (ContainerInterface $c) {
        return new MailService($c->get(PHPMailer::class));
    },

    Repository::class => function (ContainerInterface $c) use ($basePath) {
        $dataPath = $basePath . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        return new Repository($dataPath);
    },

    
    SiteController::class => function (ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class) ? $c->get(RouteParserInterface::class) : null;
        $db = $c->has(PDO::class) ? $c->get(PDO::class) : null;
        return new SiteController($routeParser, null);
    },

    SolicitacaoController::class => function (ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class) ? $c->get(RouteParserInterface::class) : null;
        $mailService = $c->get(MailService::class);  
        $repo = $c->get(Repository::class);
        return new SolicitacaoController($routeParser, $mailService, $repo);
    },

   GerarPDFController::class => function (ContainerInterface $c) {
        $routeParser = $c->get(RouteParserInterface::class);       
        return new GerarPDFController($routeParser);
    },

    AcompanhamentoController::class => function (ContainerInterface $c) {
        $routeParser = $c->has(RouteParserInterface::class) ? $c->get(RouteParserInterface::class) : null;
        $repo = $c->get(Repository::class);
        return new AcompanhamentoController($routeParser, $repo);
    },

];