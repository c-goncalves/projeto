<?php
namespace App\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Factory\ResponseFactory;

class UrlSlashMiddleware implements MiddlewareInterface
{
    public const MODE_REMOVE = 'remove';
    public const MODE_ADD    = 'add';

    private string $mode;
    private ResponseFactory $responseFactory;
    private int $redirectStatus;

    public function __construct(string $mode = self::MODE_REMOVE, int $redirectStatus = 301)
    {
        $this->mode = $mode === self::MODE_ADD ? self::MODE_ADD : self::MODE_REMOVE;
        $this->responseFactory = new ResponseFactory();
        $this->redirectStatus = $redirectStatus;
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        $path = preg_replace('#/+#', '/', str_replace('\\', '/', $path));
        if ($path === '' || $path === '/') {
            return $handler->handle($request);
        }

        $hasTrailing = str_ends_with($path, '/');

        if ($this->mode === self::MODE_REMOVE && $hasTrailing) {
            $newPath = rtrim($path, '/');
            if ($newPath === '') {
                $newPath = '/';
            }
            return $this->buildRedirect($uri, $newPath);
        }

        if ($this->mode === self::MODE_ADD && !$hasTrailing) {
            $newPath = $path . '/';
            return $this->buildRedirect($uri, $newPath);
        }

        return $handler->handle($request);
    }

    private function buildRedirect($uri, string $newPath): Response
    {
        $newUri = $uri->withPath($newPath);

        $response = $this->responseFactory->createResponse($this->redirectStatus);
        return $response->withHeader('Location', (string)$newUri);
    }
}
