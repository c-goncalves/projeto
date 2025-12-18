<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;
use App\Traits\ViewRendererTrait;

class AcompanhamentoController
{
    use ViewRendererTrait;

    private ?RouteParserInterface $routeParser;
    private string $baseTemplatesPath;
    private string $dataPath;

    public function __construct(?RouteParserInterface $routeParser = null)
    {
        $this->routeParser = $routeParser;
        $this->baseTemplatesPath = __DIR__ . "/../../templates/";
        $this->dataPath = __DIR__ . "/../../data/";
    }

    public function index(Request $request, Response $response): Response
    {
        $file = $this->dataPath . 'solicitacoes.json';
        $solicitacoes = [];
        
        if (file_exists($file)) {
            $solicitacoes = json_decode(file_get_contents($file), true) ?: [];
        }

        $computed = $this->computeBaseUrls();
        $data = $computed + [
            'title' => 'Acompanhamento de Solicitações',
            'solicitacoes' => $solicitacoes,
            'routeParser' => $this->routeParser
        ];

        $templatePath = $this->baseTemplatesPath . 'acompanhamento/lista.php';
        
        if (!file_exists($templatePath)) {
            $content = "<h1>Lista de Solicitações</h1><p>Em breve os dados do JSON aparecerão aqui.</p>";
        } else {
            $content = $this->renderTemplate($templatePath, $data);
        }

        $html = $this->renderLayout($content, $data);
        $response->getBody()->write($html);
        return $response;
    }
}