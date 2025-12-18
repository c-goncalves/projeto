<?php
namespace App\Controllers;

use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface; 
use PDO;

class GerarPDFController {

    protected $routeParser;
    protected $db;
    private $baseLayoutsPath;
    protected $tempPath;

   public function __construct(RouteParserInterface $routeParser, PDO $db = null) {
        $this->routeParser = $routeParser;
        $this->db = $db;
        $this->baseLayoutsPath = __DIR__ . "/../../templates/pdf/";
        $this->tempPath = __DIR__ . "/../../storage/tmp/";
    }

    public function gerarDocumento(Request $request, Response $response, array $args): Response {
        $tipo = $args['tipo']; 
        $dados = $_SESSION['dados_validados'] ?? null;
        // die(var_dump($_SESSION));
        if (session_status() !== PHP_SESSION_ACTIVE) {
            die("ERRO: A sessão não foi iniciada no PHP!");
        }
        
        if (empty($_SESSION)) {
            die("ERRO: A sessão está ativa mas está totalmente VAZIA. O redirect limpou os dados.");
        }
        
        $tempDir = $this->tempPath; 
        
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        if (!$dados) {
            return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.index'))->withStatus(302);
        }

        try {
            $mpdf = new Mpdf([
                'format' => 'A4',
                'margin_left' => 24, 'margin_right' => 14, 'margin_top' => 14, 'margin_bottom' => 14,
                'tempDir' => $tempDir 
            ]);
            
            switch ($tipo) {
                case 'tce':
                    $html = $this->renderizarTce($dados);
                    break;
                case 'plano':
                    $html = $this->renderizarTce($dados); 
                    break;
                default:
                    throw new \Exception("Tipo de documento inválido.");
            }

            $mpdf->SetTitle("Documento de Estágio - " . ($dados['estagiario']['nome'] ?? 'IFSP'));
            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', 'S');
            
            $response->getBody()->write($pdfContent);
            return $response->withHeader('Content-Type', 'application/pdf')
                             ->withHeader('Content-Disposition', "inline; filename=\"{$tipo}.pdf\"");
        } catch (\Exception $e) {
            // $_SESSION['erro_api'] = "Erro na geração: " . $e->getMessage();
            // return $response->withHeader('Location', $this->routeParser->urlFor('solicitacao.index'))->withStatus(302);
            echo "<h1>Erro Detectado:</h1>";
            echo "<p><strong>Mensagem:</strong> " . $e->getMessage() . "</p>";
            echo "<p><strong>Arquivo:</strong> " . $e->getFile() . " na linha " . $e->getLine() . "</p>";
            echo "<pre><strong>Stack Trace:</strong>\n" . $e->getTraceAsString() . "</pre>";
            exit;
        }
    }

    private function renderizarTce($dados) {
        $templatePath = $this->baseLayoutsPath . 'termo_layout.html';
        if (!file_exists($templatePath)) {
            throw new \Exception("Template não encontrado em: " . $templatePath);
        }
        $template = file_get_contents($templatePath);
        return $this->processarSubstituicoes($template, $dados);
    }

    private function processarSubstituicoes($html, $d) {
       $f = function($valor) {
            return ($valor !== null && $valor !== '') ? $valor : '__________'; 
        };
        $u = $d['unidade_concedente'] ?? [];
        $s = $d['supervisor'] ?? [];
        $e = $d['estagiario'] ?? [];
        $est = $d['dados_estagio'] ?? [];
        
        // Lógica de Seguro (Cláusula Quarta)
        $apoliceTexto = $e['estagio_obrigatorio'] 
            ? "o IFSP se responsabiliza pela contratação de seguro contra acidentes pessoais em nome do ESTAGIÁRIO, conforme previsto no Parágrafo único do Art. 9º da Lei 11.788"
            : "o ESTAGIÁRIO estará coberto pela apólice de seguro n° {$est['numero_apolice_seguro']}, da Seguradora {$est['nome_seguradora']} no valor de R$ " . number_format($est['valor_seguro'], 2, ',', '.') . " contra Acidentes Pessoais.";


        $substituicoes = [
            '{{LOGO_PATH}}' => __DIR__ . '/../../public/assets/logo_termo2.jpg',
            
            // UNIDADE CONCEDENTE
            '{{EMPRESA_RAZAO_SOCIAL}}'        => $f($u['razao_social'] ?? null),
            '{{EMPRESA_CNPJ}}'                => $f($u['cnpj'] ?? null),
            '{{EMPRESA_INSCRICAO_ESTADUAL}}'  => $u['insc_estadual'] ?? 'N/A',
            '{{EMPRESA_CPF}}'                 => $u['cpf'] ?? 'N/A',
            '{{EMPRESA_FONE}}'                => $f($u['telefone'] ?? null),
            '{{EMPRESA_ENDERECO}}'            => $f($u['endereco']['endereco'] ?? null),
            '{{EMPRESA_CEP}}'                 => $f($u['endereco']['cep'] ?? null),
            '{{EMPRESA_BAIRRO}}'              => $f($u['endereco']['bairro'] ?? null),
            '{{EMPRESA_CIDADE}}'              => $f($u['endereco']['cidade'] ?? null),
            '{{EMPRESA_ESTADO}}'              => $f($u['endereco']['estado'] ?? null),
            '{{EMPRESA_REPRESENTANTE}}'       => $f($u['representante_legal']['nome'] ?? null),
            '{{EMPRESA_CARGO_REPRESENTANTE}}' => $f($u['representante_legal']['cargo'] ?? null),

            // SUPERVISOR
            '{{SUPERVISOR_NOME}}'     => $f($s['nome'] ?? null),
            '{{SUPERVISOR_CPF}}'      => $f($s['cpf'] ?? null),
            '{{SUPERVISOR_CARGO}}'    => $f($s['cargo'] ?? null),
            '{{SUPERVISOR_FORMACAO}}' => $f($s['formacao_academica'] ?? null),
            '{{SUPERVISOR_REG_PROF}}' => $s['registro_professionale']['numero'] ?? $s['registro_profissional']['numero'] ?? '_____',
            '{{SUPERVISOR_ORGAO}}'    => $s['registro_professionale']['orgao'] ?? $s['registro_profissional']['orgao'] ?? '_____',
            '{{SUPERVISOR_EMAIL}}'    => $f($s['email'] ?? null),

            // ESTAGIÁRIO
            '{{ALUNO_NOME}}'      => $f($e['nome'] ?? null),
            '{{ALUNO_CURSO}}'     => $f($e['curso'] ?? null),
            '{{ALUNO_PERIODO}}'   => $f($e['periodo'] ?? null),
            '{{ALUNO_PRONTUARIO}}' => $f($e['prontuario'] ?? null),
            '{{ALUNO_RG}}'        => $f($e['rg'] ?? null),
            '{{ALUNO_CPF}}'       => $f($e['cpf'] ?? null),
            '{{ALUNO_DATA_NASC}}' => !empty($e['data_nascimento']) ? date('d/m/Y', strtotime($e['data_nascimento'])) : '___/___/_____',
            '{{ALUNO_ENDERECO}}'  => $f($e['endereco']['endereco'] ?? null),
            '{{ALUNO_CEP}}'       => $f($e['endereco']['cep'] ?? null),
            '{{ALUNO_BAIRRO}}'    => $f($e['endereco']['bairro'] ?? null),
            '{{ALUNO_CIDADE}}'    => $f($e['endereco']['cidade'] ?? null),
            '{{ALUNO_ESTADO}}'    => $f($e['endereco']['estado'] ?? null),
            '{{ALUNO_FONE}}'      => $e['telefone'] ?? 'N/A',
            '{{ALUNO_CEL}}'       => $f($e['celular'] ?? null),
            '{{ALUNO_EMAIL}}'     => $f($e['email'] ?? null),
            
            // CHECKBOXES (X)
            '{{ESTAGIO_OBRIGATORIO_X}}'     => ($e['estagio_obrigatorio'] ?? false) ? 'X' : '',
            '{{ESTAGIO_NAO_OBRIGATORIO_X}}' => !($e['estagio_obrigatorio'] ?? false) ? 'X' : '',
            '{{PCD_X}}'                     => ($e['portador_de_deficiencia'] ?? false) ? 'X' : '',

            // DADOS ESTÁGIO
            '{{DATA_INICIO}}'   => !empty($est['data_inicio']) ? date('d/m/Y', strtotime($est['data_inicio'])) : '___/___/_____',
            '{{DATA_FIM}}'      => !empty($est['data_termino']) ? date('d/m/Y', strtotime($est['data_termino'])) : '___/___/_____',
            '{{DATA_TERMINO}}'  => !empty($est['data_termino']) ? date('d/m/Y', strtotime($est['data_termino'])) : '___/___/_____',
            '{{JORNADA_DESCRICAO}}' => !empty($est['horas_semanais']) ? $est['horas_semanais'] . " horas semanais" : '__________',
            '{{BOLSA_NUMERICA}}'    => number_format(($est['valor_bolsa_auxilio'] ?? 0), 2, ',', '.'),
            '{{BOLSA_EXTENSO}}'     => "Valor Mensal", 
            '{{APOLICE_SEGURO_TEXTO}}' => $apoliceTexto,

            // DATAS ATUAIS
            '{{DATA_ATUAL_DIA}}' => date("d"),
            '{{DATA_ATUAL_MES}}' => $this->getMesPt(date("n")),
            '{{DATA_ATUAL_ANO}}' => date("Y"),
        ];

   

       

        return str_replace(array_keys($substituicoes), array_values($substituicoes), $html);
    }

    private function getMesPt($n) {
        $meses = [1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro"];
        return $meses[$n];
    }
}