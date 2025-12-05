<?php
namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;

class RoleMiddleware implements MiddlewareInterface
{
    private $requiredRoles; // array ou string
    private $responseFactory;

    public function __construct($requiredRoles)
    {
        $this->requiredRoles = (array)$requiredRoles;
        $this->responseFactory = new ResponseFactory();
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $user = $request->getAttribute('user') ?? $_SESSION['user'] ?? null;

        if (!$user) {
            $resp = $this->responseFactory->createResponse(401);
            $resp->getBody()->write('Unauthorized');
            return $resp;
        }

        $userRoles = $user['roles'] ?? []; // espera array
        foreach ($this->requiredRoles as $role) {
            if (in_array($role, $userRoles, true)) {
                return $handler->handle($request);
            }
        }

        // sem permissão
        $resp = $this->responseFactory->createResponse(403);
        $resp->getBody()->write('Forbidden');
        return $resp;
    }
}
