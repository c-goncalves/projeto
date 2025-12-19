<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;
use App\Traits\ViewRendererTrait;
use App\Services\Repository;

class AcompanhamentoController
{
    use ViewRendererTrait;

    private ?RouteParserInterface $routeParser;
    private Repository $repository;
    private string $baseTemplatesPath;

    public function __construct(Repository $repository, ?RouteParserInterface $routeParser = null)
    {
        $this->routeParser = $routeParser;
        $this->repository = $repository;
        $this->baseTemplatesPath = __DIR__ . "/../../templates/";
    }

    public function index(Request $request, Response $response): Response
    {
        $data = $this->computeBaseUrls() + [
            'title' => 'Acompanhamento de Solicitações',
            'routeParser' => $this->routeParser
        ];

        $content = $this->renderTemplate($this->baseTemplatesPath . 'acompanhamento/index.php', $data);
        $html = $this->renderLayout($content, $data);
        
        $response->getBody()->write($html);
        return $response;
    }

    public function consultar(Request $request, Response $response): Response 
    {
        $params = (array)$request->getParsedBody();
        $chaveBuscada = trim($params['chave'] ?? '');
        $todas = $this->repository->all();
        $solicitacaoEncontrada = null;

        foreach ($todas as $item) {
            if (isset($item['chave_acesso_aluno']) && $item['chave_acesso_aluno'] === $chaveBuscada) {
                $solicitacaoEncontrada = $item;
                break;
            }
        }

        if (!$solicitacaoEncontrada) {
            $_SESSION['erro_acompanhamento'] = "Protocolo não encontrado.";
            return $response->withHeader('Location', $this->routeParser->urlFor('acompanhamento.index'))->withStatus(302);
        }

        $data = $this->computeBaseUrls() + [
            'title' => 'Dashboard da Solicitação',
            'dados' => $solicitacaoEncontrada,
            'routeParser' => $this->routeParser
        ];

        $content = $this->renderTemplate($this->baseTemplatesPath . 'acompanhamento/dashboard.php', $data);
        $html = $this->renderLayout($content, $data);

        $response->getBody()->write($html);
        return $response;
    }
}