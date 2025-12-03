<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Traits\ViewRendererTrait;


class SiteController
{
    use ViewRendererTrait; 
    private $baseTemplatesPath;
    private $basePartialsPath;


    public function __construct()
    {
        $this->baseTemplatesPath = __DIR__ . "/../../templates/";
        $this->basePartialsPath = __DIR__ . "/../../templates/partials/"; 
        $routeParser = $app->getRouteCollector()->getRouteParser();
    }
    
    
    public function home(Request $request, Response $response): Response
    {
        $template_path = $this->baseTemplatesPath . 'site/home.php'; 
        $page_content = $this->renderTemplate($template_path, [
            'pageTitle' => 'SGE',
            'routeParser' => $this->routeParser
        ]);
        // $page_content = $this->renderTemplate($template_path, ['pageTitle' => 'Página Inicial']);
        $final_html = $this->renderLayout($page_content);
        
        $response->getBody()->write($final_html);
        return $response;
    }

    public function recursos(Request $request, Response $response): Response
    {
        $template_path = $this->baseTemplatesPath . 'site/recursos.php';
        
        $page_content = $this->renderTemplate($template_path, ['pageTitle' => 'Recursos e Normas']);
        $final_html = $this->renderLayout($page_content);
        
        $response->getBody()->write($final_html);
        return $response;
    }

}