<?php
require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controllers\SiteController;

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions(require __DIR__ . '/../config/services.php');
$container = $containerBuilder->build();
AppFactory::setContainer($container);
$app = AppFactory::create();
$routeParser = $app->getRouteCollector()->getRouteParser();
$app->run();