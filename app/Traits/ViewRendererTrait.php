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
    
    private function renderLayout(string $content): string
    {
        // inclui o header e o footer
        ob_start();
        require $this->basePartialsPath . 'header.php';
        $header = ob_get_clean();
        
        ob_start();
        require $this->basePartialsPath . 'footer.php';
        $footer = ob_get_clean();
        
        return $header . $content . $footer;
    }
}