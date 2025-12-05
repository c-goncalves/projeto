<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    public function showLogin(Request $request, Response $response): Response
    {
        $returnTo = $request->getQueryParams()['returnTo'] ?? '/';
        ob_start();
        include __DIR__ . '/../../templates/auth/login.php';
        $response->getBody()->write(ob_get_clean());
        return $response;
    }

    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if ($email === 'admin@example.com' && $password === 'senha123') {
            $_SESSION['user'] = [
                'id' => 1,
                'name' => 'Admin Exemplo',
                'email' => $email,
                'roles' => ['admin', 'editor'],
            ];

            $returnTo = $data['returnTo'] ?? '/';
            return (new \Slim\Psr7\Factory\ResponseFactory())
                ->createResponse(302)
                ->withHeader('Location', $returnTo);
        }

        $params = http_build_query(['error' => 'invalid_credentials']);
        return (new \Slim\Psr7\Factory\ResponseFactory())
                ->createResponse(302)
                ->withHeader('Location', '/login?' . $params);
    }

    public function logout(Request $request, Response $response): Response
    {
        unset($_SESSION['user']);
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
        return (new \Slim\Psr7\Factory\ResponseFactory())
                ->createResponse(302)
                ->withHeader('Location', '/login');
    }
}
