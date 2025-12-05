<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;
use App\Traits\ViewRendererTrait;

class SolicitacaoController
{
    use ViewRendererTrait;

    private string $baseFormsPath;
    private string $basePartialsPath;
    private string $baseTemplatesPath;
    private ?RouteParserInterface $routeParser = null;

    public function __construct(?RouteParserInterface $routeParser = null)
    {
        $this->baseFormsPath     = __DIR__ . "/../../templates/solicitacoes/forms/";
        $this->basePartialsPath  = __DIR__ . "/../../templates/partials/";
        $this->baseTemplatesPath = __DIR__ . "/../../templates/";
        $this->routeParser = $routeParser;
    }

    private function loadDocument(Response $response, string $doc_base, string $tipo_estagio = null): Response
    {
        $curso = $_GET['curso'] ?? 'outros';
        $template_name = $doc_base;

        if (in_array($doc_base, ['tce', 'pae', 'ta', 'trtc']) && strtolower($curso) === 'lic') {
            $template_name .= '_lic';
        }
        $template_name .= '.php';

        $include_path = $this->baseFormsPath . $template_name;

        ob_start();

        if (file_exists($include_path)) {
            require_once $include_path;
        } else {
            error_log("SolicitacaoController: Template não encontrado: {$include_path}");
            $response->getBody()->write("<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro: O template ({$template_name}) não foi encontrado.</div>");
            return $response->withStatus(404);
        }

        $current_uri = $_SERVER['REQUEST_URI'] ?? '';
        $function_name = 'print_' . $doc_base;

        if (function_exists($function_name)) {
            $function_name(BASE_URL, $current_uri, $curso);
        } else {
            ob_get_clean();
            $response->getBody()->write("<div class=\"p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800\">Aviso: Função {$function_name} não está carregada.</div>");
            return $response->withStatus(500);
        }

        $html_content = ob_get_clean();

        $computed = $this->computeBaseUrls(); // retorna ['BASE_URL'=>..., 'ASSETS_URL'=>...]

        $vars = $computed + [
            'routeParser'   => $this->routeParser ?? null,
            'doc_base'      => $doc_base,
            'tipo_estagio'  => $tipo_estagio,
            'curso'         => $curso,
            // vars->layout/templates
        ];

        $final_html = $this->renderLayout($html_content, $vars);

        $response->getBody()->write($final_html);
        return $response;
    }

    public function home(Request $request, Response $response): Response
    {
        $templatePath = $this->baseTemplatesPath . 'solicitacoes/inicio.php';

        if (!file_exists($templatePath)) {
            error_log("SolicitacaoController::home: Template não encontrado em: {$templatePath}");
            $response->getBody()->write("<h1>Erro 404: Template {$templatePath} não encontrado.</h1>");
            return $response->withStatus(404);
        }

        $content = $this->renderTemplate($templatePath, [
            'title' => 'Página Inicial',
        ]);

        $computed = $this->computeBaseUrls();
        $vars = $computed + [
            'routeParser' => $this->routeParser ?? null,
            'title'       => 'Página Inicial',
        ];

        $finalHtml = $this->renderLayout($content, $vars);

        $response->getBody()->write($finalHtml);
        return $response;
    }

    public function termo(Request $request, Response $response, array $args): Response
    {
        return $this->loadDocument($response, 'tce', $args['tipo'] ?? null);
    }

    public function plano(Request $request, Response $response, array $args): Response
    {
        return $this->loadDocument($response, 'pae', $args['tipo'] ?? null);
    }

    public function rsem(Request $request, Response $response): Response
    {
        return $this->loadDocument($response, 'rsem');
    }

    public function ta(Request $request, Response $response, array $args): Response
    {
        return $this->loadDocument($response, 'ta', $args['tipo'] ?? null);
    }

    public function trtc(Request $request, Response $response, array $args): Response
    {
        return $this->loadDocument($response, 'trtc', $args['tipo'] ?? null);
    }

    public function gerarPdf(Request $request, Response $response): Response
    {
        $response->getBody()->write("Geração de PDF ativada.");
        return $response;
    }
}
