<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;
use App\Traits\ViewRendererTrait;

class SiteController
{
    use ViewRendererTrait;

    private $baseTemplatesPath;
    private $basePartialsPath;
    /** @var RouteParserInterface|null */
    private $routeParser;
    /** @var \PDO|null */
    private $db;

   public function __construct(?RouteParserInterface $routeParser = null) 
    {
        $this->baseTemplatesPath = realpath(__DIR__ . '/../../templates') . '/';
        $this->basePartialsPath = $this->baseTemplatesPath . 'partials/';
        $this->routeParser = $routeParser;
        // $this->db = $db;
    }

    public function index(Request $request, Response $response): Response
    {
        $baseUrl = "/";
        $assetsUrl = "/assets/";

        $template_path = $this->baseTemplatesPath . 'site/home.php';

        $page_content = $this->renderTemplate($template_path, [
            'pageTitle'   => 'SGE',
            'routeParser' => $this->routeParser,
            'BASE_URL'    => $baseUrl,
            'ASSETS_URL'  => $assetsUrl
        ]);

        $final_html = $this->renderLayout($page_content);

        $response->getBody()->write($final_html);
        return $response;
    }


    public function recursos(Request $request, Response $response): Response
    {
        $templatePath = $this->baseTemplatesPath . 'site/recursos.php';
        if (!file_exists($templatePath)) {
            throw new \Exception("Erro Crítico: O arquivo não foi encontrado no caminho: " . $templatePath);
        }

        $data = $this->computeBaseUrls() + [
            'pageTitle'   => 'Recursos e Normas',
            'routeParser' => $this->routeParser
        ];

        $content = $this->renderTemplate($templatePath, $data);
        $html = $this->renderLayout($content, $data);

        $response->getBody()->write($html);
        return $response;
    }
}
