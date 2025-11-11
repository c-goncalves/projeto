
<?php

class Router {
    private $routes = [];
    private $params = [];
    private $current_route = '';
    
    /**
     * rota GET
     * @param string $route - Padrão da rota (ex: 'solicitacoes/{step}')
     * @param string $page  - Página a carregar (ex: 'solicitacoes/index')
     */
    public function get($route, $page) {
        $this->routes['GET'][$route] = $page;
    }
    
    // post
    public function post($route, $page) {
        $this->routes['POST'][$route] = $page;
    }
    
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $route = $this->parseUrl();
        
        // rota exata
        if (isset($this->routes[$method][$route])) {
            $this->loadPage($this->routes[$method][$route]);
            return;
        }
        
        // rota com parâmetros
        foreach ($this->routes[$method] as $pattern => $page) {
            if ($this->matchRoute($pattern, $route)) {
                $this->loadPage($page);
                return;
            }
        }
        
        $this->notFound();
    }
    
    private function parseUrl() {
        $base_path = dirname($_SERVER['SCRIPT_NAME']);
        $request_uri = $_SERVER['REQUEST_URI'];
        
        if ($base_path !== '/' && strpos($request_uri, $base_path) === 0) {
            $request_uri = substr($request_uri, strlen($base_path));
        }
        
        if (strpos($request_uri, '?') !== false) {
            $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));
        }
        
        $this->current_route = trim($request_uri, '/');
        
        return $this->current_route;
    }
    
    private function matchRoute($pattern, $url) {
        $regex = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';
        
        if (preg_match($regex, $url, $matches)) {
            array_shift($matches);
            
            preg_match_all('/\{([^}]+)\}/', $pattern, $param_names);
            
            // Associa valores aos nomes
            // foreach ($param_names[1] as $index => $name) {
            //     if (isset($matches[$index])) {
            //         $_GET[$name] = $matches[$index];
            //     }
            // }
            foreach ($param_names[1] as $index => $name) {
                if (isset($matches[$index])) {
                    $_GET[$name] = $matches[$index];
                    $this->params[$name] = $matches[$index];
                }
            }

            
            return true;
        }
        
        return false;
    }
    
    // get
    private function loadPage($page) {
        $page_path = PAGES_PATH . $page . '.php';
        
        if (file_exists($page_path)) {
            // added
            $params = $this->params; 
            require $page_path;
        } else {
            $this->notFound();
        }
    }

    
    //404
    private function notFound() {
        http_response_code(404);
        echo "
        <div style='padding: 50px; text-align: center;'>
            <h1>404 - Página não encontrada</h1>
            <p>A rota '{$this->current_route}' não existe.</p>
            <a href='" . BASE_URL . "'>Voltar à homepage</a>
        </div>";
        exit;
    }
    
    public function getParams() {
        return $this->params;
    }
}

?>
