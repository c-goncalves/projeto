<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;
use App\Traits\ViewRendererTrait;
use App\Services\MailService;
use App\Services\Repository;
use PDO; 

class SolicitacaoController
{
    use ViewRendererTrait;

    private string $baseFormsPath;
    private string $basePartialsPath;
    private string $baseTemplatesPath;
    private ?RouteParserInterface $routeParser = null;
    private string $dataPath;
    private MailService $mailService;
    private Repository $repository;

    public function __construct(?RouteParserInterface $routeParser = null, ?MailService $mailService = null, ?Repository $repository = null){
        $this->baseFormsPath = __DIR__ . "/../../templates/solicitacoes/forms/";
        $this->basePartialsPath = __DIR__ . "/../../templates/partials/";
        $this->baseTemplatesPath = __DIR__ . "/../../templates/";
        $this->routeParser = $routeParser;
        $this->mailService = $mailService;
        $this->repository  = $repository;
        $this->dataPath = __DIR__ . "/../../data/";
    }

    public function home(Request $request, Response $response): Response {
        $templatePath = $this->baseTemplatesPath . 'solicitacoes/inicio.php';
        if (!file_exists($templatePath)) {
            $response->getBody()->write("<h1>Erro de template.</h1>");
            return $response->withStatus(404);
        }

        $computed = $this->computeBaseUrls();
        
        $dataForTemplate = $computed + [
            'title'       => 'Página Inicial',
            'routeParser' => $this->routeParser,
            'current_uri' => $_SERVER['REQUEST_URI'] ?? '/',
        ];

        try {
            // Conteudo da pagina
            $content = $this->renderTemplate($templatePath, $dataForTemplate);
        } catch (\Throwable $e) {
            $response->getBody()->write("<h1>Erro no conteúdo:</h1><p>" . $e->getMessage() . "</p>");
            return $response->withStatus(500);
        }

        // Vars do layout
        $varsForLayout = $computed + [
            'routeParser' => $this->routeParser,
            'title'       => 'Página Inicial',
            'basePartialsPath' => $this->basePartialsPath, 
            'BASE_URL'         => $computed['BASE_URL'],   
            'ASSETS_URL'       => $computed['ASSETS_URL']
        ];

        $finalHtml = $this->renderLayout($content, $varsForLayout);
        $response->getBody()->write($finalHtml);
        return $response;
    }

    public function termo(Request $request, Response $response, array $args): Response {
        return $this->loadDocument($request, $response, 'tce', $args['tipo'] ?? null);
    }

    public function plano(Request $request, Response $response, array $args): Response {
        return $this->loadDocument($request, $response, 'pae', $args['tipo'] ?? null);
    }

    public function rsem(Request $request, Response $response): Response {
        return $this->loadDocument($request, $response, 'rsem');
    }

    public function ta(Request $request, Response $response, array $args): Response {
        return $this->loadDocument($request, $response, 'ta', $args['tipo'] ?? null);
    }

    public function trtc(Request $request, Response $response, array $args): Response{
        return $this->loadDocument($request, $response, 'trtc', $args['tipo'] ?? null);
    }      
    
    // Formulario de envio de documentacao
    public function enviarDocumento(Request $request, Response $response, array $args): Response {
        $tipo = $args['tipo'] ?? 'documento';
        $templatePath = $this->baseTemplatesPath . 'solicitacoes/forms/upload_form.php';
        $computed = $this->computeBaseUrls();
        $data = $computed + [
            'title' => 'Enviar Documento Assinado',
            'tipo' => $tipo,
            'routeParser' => $this->routeParser
        ];

        $content = $this->renderTemplate($templatePath, $data);
        $response->getBody()->write($this->renderLayout($content, $data));
        return $response;
    }

    public function processarUpload(Request $request, Response $response): Response {
        $params = (array)$request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();
        $arquivo = $uploadedFiles['documento_pdf'] ?? null;

        if (!$arquivo || $arquivo->getError() !== UPLOAD_ERR_OK) {
            $_SESSION['erro_api'] = "Anexo do documento é obrigatório.";
            return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.enviar'))->withStatus(302);
        }

        try {
            $chaveAluno = bin2hex(random_bytes(16));
            $this->repository->salvarNova($params + [
                'chave_acesso_aluno' => $chaveAluno,
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $this->mailService->enviarConfirmacaoSolicitacao($params, $chaveAluno, $arquivo);

            $_SESSION['sucesso'] = "Enviado com sucesso! Verifique seu e-mail.";
            return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.index'))->withStatus(302);

        } catch (\Exception $e) {
            error_log("Erro no upload: " . $e->getMessage());
            $_SESSION['erro_api'] = "Erro interno ao processar sua solicitação.";
            return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.index'))->withStatus(302);
        }
    }

   

    
    
    // Validação da API
    public function processarEnvio(Request $request, Response $response): Response{
        $params = (array)$request->getParsedBody();
        array_walk_recursive($params, function (&$item) {
            if (is_string($item)) {
                $item = trim($item);
            }
        });
        if (isset($params['dados_estagio'])) {
            $params['dados_estagio']['valor_bolsa_auxilio'] = (float)($params['dados_estagio']['valor_bolsa_auxilio'] ?? 0);
            $params['dados_estagio']['valor_seguro'] = (float)($params['dados_estagio']['valor_seguro'] ?? 0);
            $params['dados_estagio']['horas_semanais'] = (int)($params['dados_estagio']['horas_semanais'] ?? 0);
        }
        $params['estagiario']['estagio_obrigatorio'] = isset($params['estagiario']['estagio_obrigatorio']);
        $params['estagiario']['portador_de_deficiencia'] = isset($params['estagiario']['portador_de_deficiencia']);
        $_SESSION['old_post'] = $params;
        $apiUrl = 'https://coordenadoria-de-extensao-api.vercel.app/validacao/';
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $apiResult = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            $_SESSION['erro_api'] = "Erro de Conexão Local: " . $error_msg;
            return $response->withHeader('Location', $request->getHeaderLine('Referer'))->withStatus(302);
        }

        curl_close($ch);
        if ($httpCode === 200) {
            $_SESSION['dados_validados'] = $params; 
            // $respostaApi = json_decode($apiResult, true);
            // $_SESSION['dados_validados'] = array_merge($params, $respostaApi['dados_processados'] ?? []);
            session_write_close();
            unset($_SESSION['old_post'], $_SESSION['erro_api']);
            return $response->withHeader('Location', $this->routeParser->urlFor('pdf.gerar', ['tipo' => 'tce']))->withStatus(302);
        }
        
        $errorData = json_decode($apiResult, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $_SESSION['erro_api'] = "Erro bruto da API: " . strip_tags($apiResult);
        } elseif (isset($errorData['detail'])) { 
            
            $detalhes = [];
            foreach ($errorData['detail'] as $err) {
                $campo = implode(' -> ', $err['loc']);
                $detalhes[] = "{$campo}: {$err['msg']}";
            }
            $_SESSION['erro_api'] = implode(' | ', $detalhes);
        } else {
            $_SESSION['erro_api'] = $errorData['message'] ?? 'Erro de validação desconhecido.';
        }

        
        $referer = $request->getHeaderLine('Referer');
        return $response->withHeader('Location', $referer)->withStatus(302);
    }

    // Gerar PDF
    public function gerarPdf(Request $request, Response $response): Response{
        $dados = $_SESSION['dados_validados'] ?? null;

        if (!$dados) {
            return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.tce'))->withStatus(302);
        }
        $html = "<h1>Termo de Compromisso de Estágio</h1>";
        $html .= "<p>Estagiário: " . $dados['dados_processados']['estagiario'] . "</p>";
        
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write("Geração de PDF ativada.");
        return $response;
    }

    // Carregar os templates dos formularios
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

    private function readJson(string $filename): array {
        $file = $this->dataPath . $filename . '.json';
        if (!file_exists($file)) return [];
        return json_decode(file_get_contents($file), true) ?: [];
    }

    private function saveJson(string $filename, array $data): void {
        $file = $this->dataPath . $filename . '.json';
        
        if (!is_dir($this->dataPath)) {
            mkdir($this->dataPath, 0777, true);
        }
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }


    

    


        
}
