<?php
namespace App\Traits;

trait ViewRendererTrait
{
    private function renderTemplate(string $path, array $data = []): string
    {
        if (!file_exists($path)) {
            return "<h1>Erro 404: Template {$path} não encontrado.</h1>";
        }

        // variáveis do array $data -> template
        extract($data);

        ob_start();
        require $path;
        return ob_get_clean();
    }

   private function renderLayout(string $content, array $vars = []): string
    {
        $computed = $this->computeBaseUrls();
        $vars = $vars + $computed;

        $vars['PARTIALS_PATH']  = rtrim($this->basePartialsPath ?? (__DIR__ . '/../../templates/partials/'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $vars['TEMPLATES_PATH'] = rtrim($this->baseTemplatesPath ?? (__DIR__ . '/../../templates/'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $vars['current_uri'] = $_SERVER['REQUEST_URI'] ?? '/';
        $vars['routeParser'] = $vars['routeParser'] ?? $this->routeParser ?? null;

        $navPath = $vars['PARTIALS_PATH'] . 'nav.php';
        $navHtml = '';

        if (file_exists($navPath) && is_readable($navPath)) {
            $navHtml = $this->renderTemplate($navPath, $vars);
        } else {
            error_log("ViewRendererTrait::renderLayout: nav.php não encontrado ou não legível em: {$navPath}");
        }

        $vars['nav_html'] = $navHtml;

        extract($vars);
        
        // header
        ob_start();
        $headerFile = $vars['PARTIALS_PATH'] . 'header.php';
        if (file_exists($headerFile) && is_readable($headerFile)) {
            require $headerFile;
        } else {
            error_log("ViewRendererTrait::renderLayout: header.php não encontrado em: {$headerFile}");
        }
        $header = ob_get_clean();

        // footer
        ob_start();
        $footerFile = $vars['PARTIALS_PATH'] . 'footer.php';
        if (file_exists($footerFile) && is_readable($footerFile)) {
            require $footerFile;
        } else {
            error_log("ViewRendererTrait::renderLayout: footer.php não encontrado em: {$footerFile}");
        }
        $footer = ob_get_clean();

        return $header . $content . $footer;
    }



  
    private function computeBaseUrls(): array
    {
        // esquema (http/https)
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        $scheme = $https ? 'https' : 'http';

        // host (comporta host:port se presente)
        $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');

        // base path 
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
         

        if ($basePath === '' || $basePath === '/') {
            $basePath = '/';
        } else {
            $basePath .= '/';
        }

        $baseUrl = $basePath;
        

        // assets url
        $assetsUrl = rtrim($baseUrl, '/') . '/assets/';

        return [
            'BASE_URL'   => $baseUrl,
            'ASSETS_URL' => $assetsUrl,
        ];
    }


}
