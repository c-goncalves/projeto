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

    /**
     * Carrega um documento (tce/pae/ta/trtc etc).
     * Usa $request para obter query params e URI atual.
     * Garantias:
     *  - disponibiliza $BASE_URL e $ASSETS_URL para os templates incluídos;
     *  - não usa require_once (evita inclusão bloqueada);
     *  - trata erros e registra logs claros.
     */
    private function loadDocument(Request $request, Response $response, string $doc_base, ?string $tipo_estagio = null): Response
    {
        // pegar query params de forma segura
        $query = $request->getQueryParams();
        $curso = isset($query['curso']) && $query['curso'] !== '' ? $query['curso'] : 'outros';
        $template_name = $doc_base;

        if (in_array($doc_base, ['tce', 'pae', 'ta', 'trtc']) && strtolower($curso) === 'lic') {
            $template_name .= '_lic';
        }
        $template_name .= '.php';

        $include_path = $this->baseFormsPath . $template_name;

        // computa BASE_URL/ASSETS_URL antes de incluir o template
        $computed = $this->computeBaseUrls(); // retorna ['BASE_URL'=>..., 'ASSETS_URL'=>...]
        $BASE_URL   = $computed['BASE_URL']   ?? '/';
        $ASSETS_URL = $computed['ASSETS_URL'] ?? rtrim($BASE_URL, '/') . '/assets/';

        // buffer para captura da saída do template
        ob_start();

        if (!file_exists($include_path) || !is_readable($include_path)) {
            error_log("SolicitacaoController: Template não encontrado ou não legível: {$include_path}");
            ob_end_clean();
            $response->getBody()->write("<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro: O template ({$template_name}) não foi encontrado.</div>");
            return $response->withStatus(404);
        }

        // Inclui o arquivo do template. Ele deve declarar a função print_<doc_base>.
        // Expor $BASE_URL/$ASSETS_URL/$routeParser no escopo do require para compatibilidade.
        try {
            // disponibiliza as variáveis no escopo do template
            $routeParserLocal = $this->routeParser ?? null;
            // incluir — usamos require (não require_once) para evitar "já incluído" em requests distintos
            require $include_path;
        } catch (\Throwable $e) {
            ob_end_clean();
            error_log("SolicitacaoController: Falha ao incluir template {$include_path}: " . $e->getMessage());
            $response->getBody()->write("<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro ao carregar template.</div>");
            return $response->withStatus(500);
        }

        // chama a função geradora de conteúdo (print_<doc_base>)
        $current_uri = (string) $request->getUri();
        $function_name = 'print_' . $doc_base;

        if (!function_exists($function_name)) {
            ob_end_clean();
            error_log("SolicitacaoController: Função {$function_name} não encontrada após incluir {$include_path}");
            $response->getBody()->write("<div class=\"p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800\">Aviso: Função {$function_name} não está carregada no template.</div>");
            return $response->withStatus(500);
        }

        // Execute a função que imprimirá o HTML do formulário no buffer.
        try {
            // passamos $BASE_URL (string), $current_uri e $curso conforme interface esperada
            $function_name($BASE_URL, $current_uri, $curso);
        } catch (\Throwable $e) {
            ob_end_clean();
            error_log("SolicitacaoController: Erro ao executar {$function_name}: " . $e->getMessage());
            $response->getBody()->write("<div class=\"p-4 bg-red-100 border-l-4 border-red-500 text-red-800\">Erro ao processar template.</div>");
            return $response->withStatus(500);
        }

        // pega o HTML gerado pelo print_*
        $html_content = ob_get_clean();

        // agora monta as variáveis para o layout (inclui routeParser para que templates usem urlFor)
        $vars = $computed + [
            'routeParser'   => $this->routeParser ?? null,
            'doc_base'      => $doc_base,
            'curso'         => $curso,
            // outras vars->layout/templates
        ];

        // renderiza layout (header, nav, footer) com o conteúdo do formulário no corpo
        try {
            $final_html = $this->renderLayout($html_content, $vars);
        } catch (\Throwable $e) {
            // se renderLayout falhar, tentamos servir o conteúdo direto como último recurso
            error_log("SolicitacaoController: renderLayout falhou: " . $e->getMessage());
            $response->getBody()->write($html_content);
            return $response->withStatus(200);
        }
        
        $response->getBody()->write($final_html);
        return $response;
    }

    // home mantém renderTemplate + renderLayout (idem anterior)
    public function home(Request $request, Response $response): Response
    {
        $templatePath = $this->baseTemplatesPath . 'solicitacoes/inicio.php';

        if (!file_exists($templatePath)) {
            error_log("SolicitacaoController::home: Template não encontrado em: {$templatePath}");
            $response->getBody()->write("<h1>Erro 404: Template {$templatePath} não encontrado.</h1>");
            return $response->withStatus(404);
        }

        // computa BASE/ASSETS e rotaParser para injetar no template
        $computed = $this->computeBaseUrls();
        $baseUrl = $computed['BASE_URL'] ?? '/';
        $assetsUrl = $computed['ASSETS_URL'] ?? rtrim($baseUrl, '/') . '/assets/';

        // tenta gerar mapa de rotas se o trait fornecer generateRoutes()
        $routesMap = [];
        if (method_exists($this, 'generateRoutes')) {
            try {
                $routesMap = $this->generateRoutes($computed);
            } catch (\Throwable $e) {
                error_log("SolicitacaoController::home: generateRoutes falhou: " . $e->getMessage());
                $routesMap = [];
            }
        }

        // Passe as variáveis necessárias pro template: routeParser, BASE_URL, ASSETS_URL, ROUTES
        $dataForTemplate = [
            'title'      => 'Página Inicial',
            'routeParser'=> $this->routeParser ?? null,
            'BASE_URL'   => $baseUrl,
            'ASSETS_URL' => $assetsUrl,
            'ROUTES'     => $routesMap,
            'current_uri'=> $_SERVER['REQUEST_URI'] ?? '/',
        ];

        // renderiza o conteúdo do template (agora com routeParser disponível)
        try {
            $content = $this->renderTemplate($templatePath, $dataForTemplate);
        } catch (\Throwable $e) {
            error_log("SolicitacaoController::home: renderTemplate falhou: " . $e->getMessage());
            $response->getBody()->write("<h1>Erro ao renderizar template da página inicial.</h1>");
            return $response->withStatus(500);
        }

        // agora renderLayout - renderLayout também injetará os mesmos computed vars
        $vars = $computed + [
            'routeParser' => $this->routeParser ?? null,
            'title'       => 'Página Inicial',
            // manter também ROUTES para partials se quiser
            'ROUTES'      => $routesMap,
        ];

        try {
            $finalHtml = $this->renderLayout($content, $vars);
        } catch (\Throwable $e) {
            error_log("SolicitacaoController::home: renderLayout falhou: " . $e->getMessage());
            // fallback: servir o conteúdo simples
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
}
