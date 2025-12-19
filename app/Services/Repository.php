<?php
namespace App\Services;

class Repository {
    private string $path;

    public function __construct(string $dataPath) {
        if (empty($dataPath)) {
            throw new \InvalidArgumentException("O path do db não pode ser vazio.");
        }
        $this->path = rtrim($dataPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function salvarNova(array $dados): void {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }

        $file = $this->path . 'solicitacoes.json';
        $solicitacoes = $this->all();
        unset($dados['documento_pdf']); 
        
        $solicitacoes[] = $dados;
        file_put_contents($file, json_encode($solicitacoes, JSON_PRETTY_PRINT));
    }

    public function all(): array {
        $file = $this->path . 'solicitacoes.json';
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    }


    public function consultar(Request $request, Response $response): Response 
    {
        $params = (array)$request->getParsedBody();
        $chaveBuscada = trim($params['chave'] ?? '');

        $todasSolicitacoes = $this->repository->all();
        $solicitacaoEncontrada = null;
        foreach ($todasSolicitacoes as $item) {
            if (isset($item['chave_acesso_aluno']) && $item['chave_acesso_aluno'] === $chaveBuscada) {
                $solicitacaoEncontrada = $item;
                break;
            }
        }

        if (!$solicitacaoEncontrada) {
            $_SESSION['erro_acompanhamento'] = "Protocolo não encontrado. Verifique se digitou corretamente.";
            return $response->withHeader('Location', $this->routeParser->urlFor('acompanhamento.index'))->withStatus(302);
        }

        $dados = $solicitacaoEncontrada;

        ob_start();
        include __DIR__ . '/../../templates/acompanhamento/resultado.php';
        $output = ob_get_clean();

        $response->getBody()->write($output);
        return $response;
    }
}