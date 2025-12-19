<?php
declare(strict_types=1);
// var_dump(getenv('SMTP_HOST')); 
// die();
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
// error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use App\Middleware\UrlSlashMiddleware;

// container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/services.php');
$container = $containerBuilder->build();

// container->AppFactory
AppFactory::setContainer($container);
$app = AppFactory::create();

// RouteParser
$routeParser = $app->getRouteCollector()->getRouteParser();
$container->set(RouteParserInterface::class, $routeParser);
// $app->setBasePath('/sistema-gestao-estagios');
// middlewares
// $app->add(new \App\Middleware\UrlSlashMiddleware('remove', 301));
$app->addRoutingMiddleware();

$displayErrorDetails = true; // false em produção
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);

// rotas
(require __DIR__ . '/../app/routes.php')($app);
// Catch-all 404 → redireciona para home
$app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{routes:.+}', function ($request, $response) {
    $response->getBody()->write('<h1>Página não encontrada</h1>');
    return $response->withStatus(404);
});


$app->run();
