<?php
namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;

class AuthMiddleware implements MiddlewareInterface
{
    private $loginPath;
    private $responseFactory;

    public function __construct(string $loginPath = '/login')
    {
        $this->loginPath = $loginPath;
        $this->responseFactory = new ResponseFactory();
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $user = $_SESSION['user'] ?? null;
        if ($user) {
            $request = $request->withAttribute('user', $user);
            return $handler->handle($request);
        }

        $accept = $request->getHeaderLine('Accept');
        if (str_contains($accept, 'application/json') || $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            $resp = $this->responseFactory->createResponse(401);
            $resp->getBody()->write(json_encode(['error' => 'Unauthorized']));
            return $resp->withHeader('Content-Type', 'application/json');
        }

        $uri = $request->getUri();
        $returnTo = (string)$uri;
        $loginUri = $this->loginPath . '?returnTo=' . urlencode($returnTo);

        $response = $this->responseFactory->createResponse(302);
        return $response->withHeader('Location', $loginUri);
    }
}
