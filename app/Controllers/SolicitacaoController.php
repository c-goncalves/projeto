<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;
use App\Traits\ViewRendererTrait;
use \Ramsey\Uuid\Uuid;

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

    public function enviarDocumento(Request $request, Response $response, array $args): Response {
        $tipo = $args['tipo'] ?? 'documento';
        
        // Caminho para o template de upload
        $templatePath = $this->baseTemplatesPath . 'solicitacoes/upload_form.php';
        
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
            $_SESSION['erro_api'] = "O arquivo PDF é obrigatório.";
            return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.enviar'))->withStatus(302);
        }

        try {
            $chaveAluno = bin2hex(random_bytes(16));
            $chaveOrientador = bin2hex(random_bytes(16));

            $sql = "INSERT INTO solicitacoes_estagio 
                    (chave_acesso_aluno, chave_acesso_orientador, status_id, aluno_nome, aluno_email, 
                    aluno_prontuario, curso_id, empresa_razao_social, empresa_cnpj, data_inicio, data_fim) 
                    VALUES (:ca, :co, :status, :nome, :email, :prontu, :curso, :empresa, :cnpj, :inicio, :fim)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ca'      => $chaveAluno,
                ':co'      => $chaveOrientador,
                ':status'  => 1, // 'Aguardando Orientador'
                ':nome'    => $params['aluno_nome'],
                ':email'   => $params['aluno_email'],
                ':prontu'  => $params['aluno_prontuario'],
                ':curso'   => $params['curso_id'],
                ':empresa' => $params['empresa_razao_social'],
                ':cnpj'    => $params['empresa_cnpj'],
                ':inicio'  => $params['data_inicio'],
                ':fim'     => $params['data_fim']
            ]);

            $solicitacaoId = $this->db->lastInsertId();

            $stmtHist = $this->db->prepare("INSERT INTO historico_solicitacao (solicitacao_id, ator, status_novo_id, comentario) VALUES (?, 'Aluno', 1, 'Documento assinado enviado pelo aluno.')");
            $stmtHist->execute([$solicitacaoId]);

            // 4. Envio de E-mail
            // Aqui você chamaria sua função de e-mail passando o $arquivo e as chaves.
            // O arquivo é lido diretamente da pasta temporária do PHP e enviado.

            $_SESSION['sucesso'] = "Documento enviado com sucesso! Guarde sua chave de acesso: " . $chaveAluno;
            return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.index'))->withStatus(302);

        } catch (\Exception $e) {
            error_log("Erro no banco: " . $e->getMessage());
            $_SESSION['erro_api'] = "Erro ao processar o registro no banco de dados.";
            return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.enviar'))->withStatus(302);
        }
    }


    

   public function processarEnvio(Request $request, Response $response): Response
    {
        // 1. Prepara e limpa os dados
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

        // 3. Executa a chamada cURL
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

        // // No método processarEnvio, logo após o curl_exec($ch):
        // $apiResult = curl_exec($ch);
        // if ($httpCode !== 200) {
        //     echo "<pre>";
        //     echo "Código HTTP: " . $httpCode . "\n";
        //     echo "Resposta Bruta:\n";
        //     print_r($apiResult); 
        //     echo "</pre>";
        //     exit; // Para a execução para você ler o erro
        // }
        // curl_close($ch);

        error_log("DEBUG API STATUS: " . $httpCode);
        error_log("DEBUG API RESPONSE: " . $apiResult);

        // 4. Trata o sucesso (200 OK)

        if ($httpCode === 200) {
            $_SESSION['dados_validados'] = $params; 
            // $respostaApi = json_decode($apiResult, true);
            // $_SESSION['dados_validados'] = array_merge($params, $respostaApi['dados_processados'] ?? []);
            session_write_close();
            unset($_SESSION['old_post'], $_SESSION['erro_api']);
            return $response->withHeader('Location', $this->routeParser->urlFor('pdf.gerar', ['tipo' => 'tce']))->withStatus(302);
        }
    //    if ($httpCode === 200) {
    //         $respostaApi = json_decode($apiResult, true);
    //         $_SESSION['dados_validados'] = $respostaApi['dados_processados'] ?? $params;
    //         unset($_SESSION['old_post'], $_SESSION['erro_api']);
    //         // session_write_close();
    //         return $response->withHeader('Location', $this->routeParser->urlFor('pdf.gerar', ['tipo' => 'tce']))->withStatus(302);
    //     }

        // 5. Trata os erros detalhados da API v3-1 (padrão Pydantic/detail)
        $errorData = json_decode($apiResult, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $_SESSION['erro_api'] = "Erro bruto da API: " . strip_tags($apiResult);
        } elseif (isset($errorData['detail'])) { 
            // A API v3-1 usa 'detail' para erros de validação
            $detalhes = [];
            foreach ($errorData['detail'] as $err) {
                $campo = implode(' -> ', $err['loc']);
                $detalhes[] = "{$campo}: {$err['msg']}";
            }
            $_SESSION['erro_api'] = implode(' | ', $detalhes);
        } else {
            $_SESSION['erro_api'] = $errorData['message'] ?? 'Erro de validação desconhecido.';
        }

        // session_write_close();
        $referer = $request->getHeaderLine('Referer');
        return $response->withHeader('Location', $referer)->withStatus(302);
    }


        
}
