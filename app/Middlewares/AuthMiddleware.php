<?php
namespace App\Middlewares;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // Verificação de Sessão
        if (!isset($_SESSION['coordenador_logado']) || $_SESSION['coordenador_logado'] !== true) {
            
            // Não autenticado->login
            $response = new Response();
            return $response->withHeader('Location', '/login')->withStatus(302);
        }
        
        // autenticado
        $response = $handler->handle($request);
        return $response;
    }
}