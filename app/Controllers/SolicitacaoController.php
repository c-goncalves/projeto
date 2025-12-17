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

    private function loadDocument(Request $request, Response $response, string $doc_base, ?string $tipo_estagio = null, array $extraData = []): Response {
        $query = $request->getQueryParams();
        $curso = isset($query['curso']) && $query['curso'] !== '' ? $query['curso'] : 'outros';
        $template_name = $doc_base;

        $old_post = $_SESSION['old_post'] ?? [];
        $erro_api = $_SESSION['erro_api'] ?? null;
        unset($_SESSION['erro_api']);

        if (in_array($doc_base, ['tce', 'pae', 'ta', 'trtc']) && strtolower($curso) === 'lic') {
            $template_name .= '_lic';
        }
        $template_name .= '.php';

        $include_path = $this->baseFormsPath . $template_name;
        $computed = $this->computeBaseUrls(); 
        $BASE_URL   = $computed['BASE_URL']   ?? '/';
        
        ob_start();

        if (!file_exists($include_path) || !is_readable($include_path)) {
            ob_end_clean();
            $response->getBody()->write("Erro: Template não encontrado.");
            return $response->withStatus(404);
        }

        try {
            require $include_path;
        } catch (\Throwable $e) {
            ob_end_clean();
            return $response->withStatus(500);
        }

        $current_uri = (string) $request->getUri();
        $function_name = 'print_' . $doc_base;

        if (function_exists($function_name)) {
            try {
                $function_name($BASE_URL, $current_uri, $curso, $old_post, $erro_api);
            } catch (\Throwable $e) {
                ob_end_clean();
                error_log("Erro ao executar {$function_name}: " . $e->getMessage());
                return $response->withStatus(500);
            }
        }

        $html_content = ob_get_clean();
        $vars = $computed + [
            'routeParser' => $this->routeParser,
            'doc_base'    => $doc_base,
            'curso'       => $curso,
        ];

        $response->getBody()->write($this->renderLayout($html_content, $vars));
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

        $computed = $this->computeBaseUrls();
        $baseUrl = $computed['BASE_URL'] ?? '/';
        $assetsUrl = $computed['ASSETS_URL'] ?? rtrim($baseUrl, '/') . '/assets/';
        $mensagem_erro = $extraData['erro'] ?? null;

        $routesMap = [];
        if (method_exists($this, 'generateRoutes')) {
            try {
                $routesMap = $this->generateRoutes($computed);
            } catch (\Throwable $e) {
                error_log("SolicitacaoController::home: generateRoutes falhou: " . $e->getMessage());
                $routesMap = [];
            }
        }

        $dataForTemplate = [
            'title'      => 'Página Inicial',
            'routeParser'=> $this->routeParser ?? null,
            'BASE_URL'   => $baseUrl,
            'ASSETS_URL' => $assetsUrl,
            'ROUTES'     => $routesMap,
            'current_uri'=> $_SERVER['REQUEST_URI'] ?? '/',
            'mensagem_erro'=>$mensagem_erro,
        ];

        try {
            $content = $this->renderTemplate($templatePath, $dataForTemplate);
        } catch (\Throwable $e) {
            error_log("SolicitacaoController::home: renderTemplate falhou: " . $e->getMessage());
            $response->getBody()->write("<h1>Erro ao renderizar template da página inicial.</h1>");
            return $response->withStatus(500);
        }

        $vars = $computed + [
            'routeParser' => $this->routeParser ?? null,
            'title'       => 'Página Inicial',
            'ROUTES'      => $routesMap,
        ];

        try {
            $finalHtml = $this->renderLayout($content, $vars);
        } catch (\Throwable $e) {
            error_log("SolicitacaoController::home: renderLayout falhou: " . $e->getMessage());
            $response->getBody()->write($content);
            return $response->withStatus(200);
        }

        $response->getBody()->write($finalHtml);
        return $response;
    }


    public function termo(Request $request, Response $response, array $args): Response
    {
        return $this->loadDocument($request, $response, 'tce', $args['tipo'] ?? null);
    }

    public function plano(Request $request, Response $response, array $args): Response
    {
        return $this->loadDocument($request, $response, 'pae', $args['tipo'] ?? null);
    }

    public function rsem(Request $request, Response $response): Response
    {
        return $this->loadDocument($request, $response, 'rsem');
    }

    public function ta(Request $request, Response $response, array $args): Response
    {
        return $this->loadDocument($request, $response, 'ta', $args['tipo'] ?? null);
    }

    public function trtc(Request $request, Response $response, array $args): Response
    {
        return $this->loadDocument($request, $response, 'trtc', $args['tipo'] ?? null);
    }

    public function gerarPdf(Request $request, Response $response): Response
    {
        $response->getBody()->write("Geração de PDF ativada.");
        return $response;
    }

    public function processarEnvio(Request $request, Response $response): Response
        {
                
            $params = (array)$request->getParsedBody();
            $_SESSION['old_post'] = $params;

            $apiUrl = 'https://coordenadoria-de-extensao-api.vercel.app/validacao/';
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);

            $apiResult = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            error_log("DEBUG API STATUS: " . $httpCode);
            error_log("DEBUG API RESPONSE: " . $apiResult);

            curl_close($ch);

            if ($httpCode === 200) {
                unset($_SESSION['old_post'], $_SESSION['erro_api']);
                session_write_close();
                return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.checklist'))->withStatus(302);
            }

            $errorData = json_decode($apiResult, true);
            if (isset($errorData['errors']) && is_array($errorData['errors'])) {
                $mensagens = [];
                foreach ($errorData['errors'] as $campo => $erro) {
                    $mensagens[] = is_array($erro) ? implode(', ', $erro) : $erro;
                }
                $_SESSION['erro_api'] = implode(' | ', $mensagens);
            } else {
                $_SESSION['erro_api'] = $errorData['message'] ?? 'Erro de validação desconhecido.';
            }

            session_write_close();
            $referer = $request->getHeaderLine('Referer');
            return $response->withHeader('Location', $referer)->withStatus(302);
        }
}
